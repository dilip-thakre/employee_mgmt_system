@extends('layout.dashboard')

@section('content')

<h1>Login with Gmail</h1>

<a href="{{ route('oauth.login') }}">Login</a>


@endsection