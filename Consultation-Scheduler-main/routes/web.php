<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\{
    LandingController, 
    LoginController, 
    RegisterController,
    UserController,
    DashboardController,
    ProfileController,
    SocketController,
    AppointmentController,
    TeacherAvailabilityController,
    InboxController
};



Route::post('logout', [LoginController::class, 'logOut'])->name('logout');
Route::get('about-us', [LandingController::class, 'aboutUs'])->name('about-us');

Route::middleware(['guest'])->group(function () {
    // Public
    Route::get('/', [LandingController::class, 'index'])->name('index');
    Route::get('/frequently-asked-questions', [LandingController::class, 'faq'])->name('frequently-asked-questions');

    // Login
    Route::get('login', [LoginController::class, 'index'])->name('login');
    Route::post('login', [LoginController::class, 'logIn'])->name('post.login'); 
    // Register
    Route::get('register', [RegisterController::class, 'index'])->name('register');
    Route::post('register', [RegisterController::class, 'register'])->name('post.register');

    Route::get('verification/{token}', [RegisterController::class, 'verification'])->name('verification');
    Route::post('verify', [RegisterController::class, 'verify'])->name('verification.post');
    Route::post('verify/resend', [RegisterController::class, 'resendVerificationCode'])->name('verification.resend');

    // Email Verification
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->middleware('auth')->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        return redirect(route('index'))->withSuccess('Email successfully verified.');
    })->middleware(['auth', 'signed'])->name('verification.verify');

    // Forgot Password
    Route::get('/forgot-password', function () {
        return view('auth.forgot-password');
    })->middleware('guest')->name('password.request');
    Route::post('/forgot-password', function (Request $request) {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return response()->json([
            'redirect_url' => redirect(route('login'))->getTargetUrl(),
            'message' => $status === Password::RESET_LINK_SENT ? 'We have e-mailed your password reset link!' : 'Error sending password reset link.',
            'success' => true,
        ], 200);
    })->middleware('guest')->name('password.email');

    Route::get('/reset-password/{token}', function ($token) {
        return view('auth.reset-password', ['token' => $token]);
    })->middleware('guest')->name('password.reset');

    Route::post('/reset-password', function (Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return response()->json([
            'redirect_url' => redirect(route('login'))->getTargetUrl(),
            'message' => $status === Password::PASSWORD_RESET ? 'You\'ve successfully changed your password!' : 'Error changing your password',
            'success' => true,
        ], 200);
    })->middleware('guest')->name('password.update');
});

Route::middleware(['auth'])->group(function () {
    Route::middleware(['teacher', 'student'])->group(function () {
        // Route::post('broadcasting/auth', [SocketController::class, 'broadcastingPrivateAuth']);
        Route::post('broadcasting/auth', [SocketController::class, 'broadcastingPresenceAuth']);

        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('/', [ProfileController::class, 'index'])->name('index');
            Route::get('/u/{id}', [ProfileController::class, 'profile'])->name('profile');
            Route::get('change-password', [ProfileController::class, 'changePassword'])->name('change-password');
            Route::prefix('update')->name('update.')->group(function () {
                Route::post('/', [ProfileController::class, 'update'])->name('user');
                Route::post('profile-photo', [ProfileController::class, 'updateProfilePhoto'])->name('profile-photo');
                Route::post('password', [ProfileController::class, 'updatePassword'])->name('password');
            });
        });

        Route::prefix('appointments')->name('appointments.')->group(function () {
            Route::get('/', [AppointmentController::class, 'index'])->name('index');
            Route::get('/status/{status}', [AppointmentController::class, 'status'])->name('status');
            Route::post('/create', [AppointmentController::class, 'create'])->name('create');
            Route::post('/update/{id}', [AppointmentController::class, 'update'])->name('update');
            Route::post('/delete', [AppointmentController::class, 'destroy'])->name('delete');
        });

        Route::prefix('teacher-availability')->name('teacher-availability.')->group(function () {
            Route::get('/', [TeacherAvailabilityController::class, 'index'])->name('index');
            Route::post('/create', [TeacherAvailabilityController::class, 'create'])->name('create');
            Route::post('/delete', [TeacherAvailabilityController::class, 'destroy'])->name('delete');
        });

        Route::prefix('inbox')->name('inbox.')->group(function () {
            // Route::get('/', [InboxController::class, 'index'])->name('index');
            // Route::post('/create/{user_id}', [InboxController::class, 'create'])->name('create');
            Route::get('/show/{conversation_id}', [InboxController::class, 'show'])->name('show');
            Route::post('/send/{conversation_id}', [InboxController::class, 'send'])->name('send');
        });

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
        Route::get('/search', [DashboardController::class, 'search'])->name('search.index');
        Route::get('/search/department/{id}', [DashboardController::class, 'department'])->name('search.department');
    });

    Route::get('complete-profile', [ProfileController::class, 'completeProfile'])->name('complete-profile');
    Route::post('complete-profile/teacher', [ProfileController::class, 'teacherProfile'])->name('complete-profile.teacher');
    Route::post('complete-profile/student', [ProfileController::class, 'studentProfile'])->name('complete-profile.student');
});