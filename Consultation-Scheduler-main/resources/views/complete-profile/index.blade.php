@extends('layouts.dashboard')
@section('content')
@include('complete-profile.'.auth()->user()->role->slug)
@endsection
@section('javascript')
@endsection