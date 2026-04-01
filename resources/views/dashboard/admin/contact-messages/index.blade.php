@extends('layouts.dashboard')
@section('title', 'Contact Messages')
@section('content')
<div class="p-6 space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-display font-bold text-gray-900">Contact Messages</h1>
            <p class="text-gray-500 mt-1">Messages sent from the contact form</p>
        </div>
        @php $unread = \App\Models\ContactMessage::where('status','unread')->count(); @endphp
        @if($unread > 0)
        <span class="bg-red-100 text-red-600 text-sm font-bold px-3 py-1.5 rounded-xl border border-red-200">
            {{ $unread }} unread
        </span>
        @endif
    </div>

    @if(session('success'))
    <div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm">
        <i class="fas fa-check-circle text-green-500"></i> {{ session('success') }}
    </div>
    @endif

    {{-- Search & Filter --}}
    <form method="GET" class="flex flex-col sm:flex-row gap-3">
        <div class="relative flex-1 max-w-md">
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search by name, email or subject..."
                   class="w-full pl-9 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary shadow-sm bg-white">
        </div>
        <select name="status" class="bg-white border border-gray-200 rounded-xl text-sm text-gray-700 px-4 py-2.5 focus:outline-none focus:border-primary shadow-sm">
            <option value="">All Messages</option>
            <option value="unread" {{ request('status') === 'unread' ? 'selected' : '' }}>Unread</option>
            <option value="read"   {{ request('status') === 'read'   ? 'selected' : '' }}>Read</option>
        </select>
        <button type="submit" class="px-5 py-2.5 bg-primary text-white rounded-xl text-sm font-medium hover:bg-primary/90 transition shadow-sm">Filter</button>
        @if(request('search') || request('status'))
            <a href="{{ route('admin.contact-messages.index') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-sm font-medium transition text-center">Clear</a>
        @endif
    </form>

    {{-- Table --}}
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                        <th class="px-6 py-4 text-left font-semibold">From</th>
                        <th class="px-6 py-4 text-left font-semibold">Subject</th>
                        <th class="px-6 py-4 text-left font-semibold">Status</th>
                        <th class="px-6 py-4 text-left font-semibold">Date</th>
                        <th class="px-6 py-4 text-right font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($messages as $msg)
                    <tr class="hover:bg-gray-50/70 transition {{ $msg->status === 'unread' ? 'bg-primary/5' : '' }}">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-primary to-purple-600 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                                    {{ strtoupper(substr($msg->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800 {{ $msg->status === 'unread' ? 'font-bold' : '' }}">{{ $msg->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $msg->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ $msg->subject }}</td>
                        <td class="px-6 py-4">
                            @if($msg->status === 'unread')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-blue-100 text-blue-700 border border-blue-200">
                                    <span class="w-1.5 h-1.5 bg-blue-500 rounded-full mr-1.5"></span> Unread
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-gray-100 text-gray-500 border border-gray-200">Read</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-400 text-xs">{{ $msg->created_at->format('d M Y, h:i A') }}</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.contact-messages.show', $msg) }}"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg text-xs font-medium transition border border-blue-100">
                                    <i class="fas fa-eye text-[10px]"></i> View
                                </a>
                                <form method="POST" action="{{ route('admin.contact-messages.destroy', $msg) }}"
                                      onsubmit="return confirm('Delete this message?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg text-xs font-medium transition border border-red-100">
                                        <i class="fas fa-trash-alt text-[10px]"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center text-gray-400">
                            <i class="fas fa-envelope-open text-4xl mb-3 block opacity-20"></i>
                            No messages yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($messages->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">{{ $messages->links() }}</div>
        @endif
    </div>
</div>
@endsection
