<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\{ Appointment, User };

class AppointmentCancelledStudentMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $student;
    protected $teacher;
    protected $appointment;

    public function __construct(User $student, User $teacher, Appointment $appointment)
    {
        $this->student = $student;
        $this->teacher = $teacher;
        $this->appointment = $appointment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'))
                    ->subject('Appointment Cancelled')
                    ->markdown('emails.appointment-cancelled-student', [
                        'student' => $this->student,
                        'teacher' => $this->teacher,
                        'appointment' => $this->appointment,
                    ]);
    }
}
