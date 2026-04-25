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
            <button type="button" onclick="openDeleteModal()" class="inline-flex items-center gap-2 px-4 py-2 bg-red-50 text-red-600 rounded-xl text-sm font-medium hover:bg-red-100 transition border border-red-100">
                <i class="fas fa-trash-alt text-xs"></i> Delete
            </button>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-xl max-w-sm w-full mx-4 overflow-hidden animate-in fade-in zoom-in duration-300">
        <div class="px-6 py-5 border-b border-gray-100 bg-red-50">
            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                <i class="fas fa-exclamation-circle text-red-600"></i>
                Delete Message
            </h3>
        </div>
        <div class="px-6 py-4">
            <p class="text-gray-700">Are you sure you want to delete this message? This action cannot be undone.</p>
        </div>
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex items-center justify-end gap-3">
            <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 text-gray-700 font-medium hover:bg-gray-100 rounded-lg transition">
                Cancel
            </button>
            <form id="deleteForm" method="POST" action="{{ route('admin.contact-messages.destroy', $contactMessage) }}" class="inline">
                @csrf @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition">
                    Delete
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function openDeleteModal() {
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('deleteModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});

// Close modal on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeDeleteModal();
    }
});
</script>
@endsection
