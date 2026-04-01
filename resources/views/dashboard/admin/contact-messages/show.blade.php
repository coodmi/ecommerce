@extends('layouts.dashboard')
@section('title', 'Message from ' . $contactMessage->name)
@section('content')
<div class="p-6 max-w-2xl">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.contact-messages.index') }}" class="text-gray-400 hover:text-gray-600 transition">
            <i class="fas fa-arrow-left text-lg"></i>
        </a>
        <h1 class="text-2xl font-bold text-gray-900">Message Details</h1>
    </div>

    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-full bg-gradient-to-br from-primary to-purple-600 flex items-center justify-center text-white font-bold">
                    {{ strtoupper(substr($contactMessage->name, 0, 1)) }}
                </div>
                <div>
                    <p class="font-bold text-gray-900">{{ $contactMessage->name }}</p>
                    <p class="text-sm text-gray-400">{{ $contactMessage->email }}
                        @if($contactMessage->phone) · {{ $contactMessage->phone }} @endif
                    </p>
                </div>
            </div>
            <span class="text-xs text-gray-400">{{ $contactMessage->created_at->format('d M Y, h:i A') }}</span>
        </div>

        <div class="px-6 py-5 space-y-4">
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1">Subject</p>
                <p class="font-semibold text-gray-800">{{ $contactMessage->subject }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1">Message</p>
                <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $contactMessage->message }}</p>
            </div>
        </div>

        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex items-center justify-between">
            <a href="mailto:{{ $contactMessage->email }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-xl text-sm font-medium hover:bg-primary/90 transition">
                <i class="fas fa-reply text-xs"></i> Reply via Email
            </a>
            <form method="POST" action="{{ route('admin.contact-messages.destroy', $contactMessage) }}"
                  onsubmit="return confirm('Delete this message?')">
                @csrf @method('DELETE')
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-red-50 text-red-600 rounded-xl text-sm font-medium hover:bg-red-100 transition border border-red-100">
                    <i class="fas fa-trash-alt text-xs"></i> Delete
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
