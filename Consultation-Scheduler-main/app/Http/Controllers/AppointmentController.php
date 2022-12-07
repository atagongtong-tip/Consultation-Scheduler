<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{ Appointment, User, Conversation };
use App\Http\Requests\{ AppointmentRequest, AppointmentStatusRequest };
use Mail;
use App\Mail\{ AppointmentApprovedStudentMail, AppointmentCancelledStudentMail, AppointmentCancelledTeacherMail, AppointmentDeclinedStudentMail, AppointmentRequestMail };

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $data = Appointment::orderBy('id', 'DESC');

        if (auth()->user()->role->slug === 'student') {
            $data->where(['user_id' => auth()->user()->id]);
        }

        if (auth()->user()->role->slug === 'teacher') {
            $data->where(['teacher_id' => auth()->user()->id]);
        }

        if ($request->ajax() || ($request->has('search') && $request->search !== '')) {
            $data->where('subject', 'like', '%'.$request->search.'%');

            return view('appointments.list', $request->all() + [
                'list' => $data->paginate(10),
            ])->render();
        }

        return view('appointments.index', $request->all() + [
            'list' => $data->paginate(10),
        ]);
    }

    public function status($status, Request $request)
    {
        if ($status === 'Cancelled' || $status === 'Declined') {
            $data = Appointment::whereIn('status', ['Cancelled', 'Declined'])->orderBy('id', 'DESC');
        } else {
            $data = Appointment::where(['status' => $status])->orderBy('id', 'DESC');
        }

        if (auth()->user()->role->slug === 'teacher') {
           $data->where(['teacher_id' => auth()->user()->id]);
        }

        if (auth()->user()->role->slug === 'student') {
           $data->where(['user_id' => auth()->user()->id]);
        }

        if ($request->ajax() || ($request->has('search') && $request->search !== '')) {
            $data->where('subject', 'like', '%'.$request->search.'%');

            return view('appointments.list', $request->all() + [
                'status' => $status,
                'list' => $data->paginate(10),
            ])->render();
        }

        return view('appointments.index', $request->all() + [
            'status' => $status,
            'list' => $data->paginate(10),
        ]);
    }

    public function create(AppointmentRequest $request)
    {
        $appointment = Appointment::create($request->all() + ['user_id' => auth()->user()->id]);

        Mail::to($appointment->teacher->email)->send(new AppointmentRequestMail($appointment->user, $appointment->teacher, $appointment));

        return response()->json([
            'redirect_url' => redirect()->route('appointments.index')->getTargetUrl(),
            'message' => 'Created Successfully.',
            'success' => true,
        ], 200); 
    }

    public function update($id, AppointmentStatusRequest $request)
    {
        $data = Appointment::find($id);
        $data->update($request->all());

        if (! empty($request->status)) {
            switch ($request->status) {
                case 'Pending':

                    break;
                case 'Declined':
                    Mail::to($data->user->email)->send(new AppointmentDeclinedStudentMail($data->user, $data->teacher, $data));
                    break;
                case 'Approved':
                    if ($request->type === 'Chat Consultation') {
                        $conversation = Conversation::create([]);
                        $conversation->participants()->create(['user_id' => $data->user_id]);
                        $conversation->participants()->create(['user_id' => $request->user()->id]);
                        $data->update(['conversation_id' => $conversation->id]);
                    }

                    Mail::to($data->user->email)->send(new AppointmentApprovedStudentMail($data->user, $data->teacher, $data));
                    break;
                case 'Completed':

                    break;
                case 'Cancelled':
                    if (auth()->user()->role->slug === 'teacher') {
                        Mail::to($data->user->email)->send(new AppointmentCancelledStudentMail($data->user, $data->teacher, $data));
                    } else {
                        Mail::to($data->teacher->email)->send(new AppointmentCancelledTeacherMail($data->user, $data->teacher, $data));
                    }

                    break;
                default:
                    # code...
                    break;
            }
        }

        return response()->json([
            'redirect_url' => redirect()->back()->getTargetUrl(),
            'message' => 'Updated Successfully.',
            'success' => true,
        ], 200); 
    }

    public function destroy(Request $request)
    {
        $data = Appointment::find($request->id);

        if ($data && $data->delete()) {
            return response()->json([
                'redirect_url' => redirect()->back()->getTargetUrl(),
                'message' => 'Successfully Deleted',
                'success' => true,
            ], 200);
        }

        return response()->json([
            'redirect_url' => redirect()->back()->getTargetUrl(),
            'message' => 'Theres an error deleting this item.',
            'success' => true,
        ], 200);
    }
}
