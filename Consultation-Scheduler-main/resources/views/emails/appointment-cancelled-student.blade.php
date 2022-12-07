@component('mail::message')
# Introduction

Hi {{ $student->first_name }} {{ $student->last_name }} your appointment has been cancelled<br><br>
Appointment Details: <br>
Status: {{ $appointment->status }}<br>
Teacher Name: {{ $teacher->first_name }} {{ $teacher->last_name }} <br>
Consultation Type: {{ $appointment->type }}<br>
Schedule: {{ \Carbon\Carbon::parse($appointment->start_schedule)->format('F d, Y') }} 
                            {{ \Carbon\Carbon::parse($appointment->start_schedule)->format('g:i A') }} - {{Carbon\Carbon::parse($appointment->end_schedule)->format('g:i A') }}<br>
Subject: {{ $appointment->subject ?? 'N/A' }}<br>
Description: {{ $appointment->description }}<br>

@component('mail::button', ['url' => route('index')])
Open {{ config('app.name') }}
@endcomponent

Thanks,<br>
{{ config('app.name') }} Team
@endcomponent