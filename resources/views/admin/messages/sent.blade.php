@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary fw-bold">
            <i class="bi bi-send-check-fill me-2"></i>Sent Messages
        </h2>
        <a href="{{ route('admin.messages.send') }}" class="btn btn-success shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Send New Message
        </a>
    </div>

    {{-- Flash Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- No messages yet --}}
    @if ($sentMessages->isEmpty())
        <div class="text-center mt-5">
            <i class="bi bi-inbox display-1 text-muted"></i>
            <h5 class="mt-3 text-muted">You haven't sent any messages yet.</h5>
        </div>
    @else
        {{-- Message cards --}}
        <div class="row">
            @foreach ($sentMessages as $message)
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="card-title text-dark mb-0">
                                    To: {{ $message->user->name }}
                                </h5>
                                <small class="text-muted">
                                    {{ $message->created_at->format('d M Y, h:i A') }}
                                </small>
                            </div>
                            <h6 class="card-subtitle text-muted mb-2">{{ $message->user->email }}</h6>
                            <p class="card-text" style="white-space: pre-wrap;">{{ $message->admin_message }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

@endsection
