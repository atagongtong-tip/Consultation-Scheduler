<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\{ HasMany, BelongsTo, HasOne, BelongsToMany, MorphToMany };
use Illuminate\Contracts\Auth\CanResetPassword;
use App\Traits\FormatDates;
use Illuminate\Support\Facades\Storage;
use DB;
use Carbon\Carbon;

class User extends Authenticatable implements MustVerifyEmail, CanResetPassword
{
    use HasApiTokens, HasFactory, Notifiable, FormatDates, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'is_super',
        'role_id',
        'status',
        'first_name',
        'last_name',
        'middle_name',
        'photo',
        'contact_no',
        'gender',
        'date_of_birth',
        'city',
        'province',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'is_admin',
        'is_current',
        'created_at_formatted',
        'deleted_at_formatted',
    ];

    public function scopeStudents($query)
    {
        $query->where('role_id', 3);
    }

    public function scopeTeachers($query)
    {
        $query->where('role_id', 2);
    }

    public function getIsAdminAttribute()
    {
        if (! auth()->check()) {
            return false;
        }

        return auth()->user()->role_id === 1;
    }

    public function getIsCurrentAttribute()
    {
        if (! auth()->check()) {
            return false;
        }

        return $this->id === auth()->user()->id;
    }

    public function getPhotoAttribute($value)
    {
        if (!$value) {
            return asset('images/avatars/user.png');
        }

        return $value;
    }

    public function getCreatedAtFormattedAttribute()
    {
        if (empty($this->attributes['created_at'])) {
            return null;
        }

        return $this->getFormatDate($this->attributes['created_at'], 'M d, Y g:i A');
    }

    public function getDeletedAtFormattedAttribute()
    {
        if (empty($this->attributes['deleted_at'])) {
            return null;
        }

        return $this->getFormatDate($this->attributes['deleted_at'], 'M d, Y g:i A');
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function studentProfile(): HasOne
    {
        return $this->hasOne(StudentProfile::class, 'user_id');
    }

    public function teacherProfile(): HasOne
    {
        return $this->hasOne(TeacherProfile::class, 'user_id');
    }

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'teacher_courses', 'user_id', 'course_id');
    }

    public function teacherAvailability(): HasMany
    {
        return $this->hasMany(TeacherAvailability::class, 'user_id');
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'user_id');
    }

    public function teacherAppointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'teacher_id');
    }
}
