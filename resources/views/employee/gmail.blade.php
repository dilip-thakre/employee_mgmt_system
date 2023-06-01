@extends('layout.dashboard')

@section('content')

<h1>Inbox Emails</h1>

<ul>
    @foreach ($emails as $email)
        <li>
            <strong>From:</strong> {{ $email->getPayload()->getHeaders()->get('From')->getValue() }}<br>
            <strong>Subject:</strong> {{ $email->getPayload()->getHeaders()->get('Subject')->getValue() }}<br>
            <strong>Date:</strong> {{ $email->getInternalDate() }}<br>
            <strong>Snippet:</strong> {{ $email->getSnippet() }}
        </li>
    @endforeach
</ul>

@endsection