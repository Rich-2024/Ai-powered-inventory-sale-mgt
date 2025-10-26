@extends('layouts.app')

@section('head')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<style>
  .message-box {
    border-radius: 10px;
    padding: 10px 15px;
    max-width: 70%;
    word-wrap: break-word;
  }
  .employee-msg {
    background-color: #d1e7dd;
    align-self: flex-end;
    text-align: right;
  }
  .admin-reply {
    background-color: #e2e3e5;
    align-self: flex-start;
    text-align: left;
  }
  .timestamp {
    font-size: 0.75rem;
    opacity: 0.6;
    margin-top: 4px;
  }
  .chat-body {
    max-height: 60vh;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    gap: 10px;
    padding: 15px;
    background: #f8f9fa;
  }
</style>
@endsection

@section('content')
<div class="container mt-0">
    <div class="bg-primary text-white py-3 mb-4">
  <div class="container d-flex align-items-center justify-content-between">
    <a href="/employee/dashboard" class="btn btn-light btn-sm">
      <i class="bi bi-arrow-left"></i> Back to Dashboard
    </a>
    <h2 class="mb-0"><i class="bi bi-chat-dots"></i> My Messages Inbox with Manager/boss</h2>
    <div style="width: 140px;"><!-- placeholder to keep center aligned --></div>
  </div>
</div>
  <h2 class="mb-4"><i class="bi bi-chat-dots"></i> get started</h2>

  <div class="card shadow-sm border-0 mb-4">
    <div class="card-body chat-body d-flex flex-column">
      @forelse ($messages as $msg)
        {{-- Employee message --}}
        @if ($msg->message)
          <div class="message-box employee-msg align-self-end">
            {!! nl2br(e($msg->message)) !!}
            <div class="timestamp">{{ $msg->created_at->format('M d, H:i') }}</div>
          </div>
        @endif

        {{-- Manager reply --}}
        @if ($msg->admin_message)
          <div class="message-box admin-reply align-self-start">
            {!! nl2br(e($msg->admin_message)) !!}
            <div class="timestamp">{{ $msg->updated_at->format('M d, H:i') }}</div>
          </div>
        @endif
      @empty
        <p class="text-center text-muted mt-3 mb-0">No messages yet.</p>
      @endforelse
    </div>
  </div>

  <div class="card shadow-sm border-0">
    <div class="card-body">
      <form method="POST" action="{{ route('chat.store') }}">
        @csrf
        <div class="mb-3">
          <textarea name="message" class="form-control" rows="3" placeholder="Type your message..." required></textarea>
        </div>
        <button type="submit" class="btn btn-success w-100">
          <i class="bi bi-send"></i> Send Message
        </button>
      </form>
    </div>
  </div>
</div>
@endsection
