@component('mail::message')
# Introduction

Hi {{ $teacher->teacherProfile->prefix ?? '' }} {{ $teacher->first_name }} {{ $teacher->last_name }} you have an appointment request<br><br>
Appointment Details: <br>
Student Name: {{ $student->first_name }} {{ $student->last_name }} <br>
Schedule: {{ \Carbon\Carbon::parse($appointment->start_schedule)->format('F d, Y') }} 
                            {{ \Carbon\Carbon::parse($appointment->start_schedule)->format('g:i A') }} - {{Carbon\Carbon::parse($appointment->end_schedule)->format('g:i A') }}<br>
Subject: {{ $appointment->subject ?? 'N/A' }}<br>
Description: {{ $appointment->description }}<br><br>

@component('mail::button', ['url' => route('index')])
Open {{ config('app.name') }}
@endcomponent

Thanks,<br>
{{ config('app.name') }} Team
@endcomponent