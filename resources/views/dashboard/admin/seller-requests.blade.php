@extends('layouts.dashboard')

@section('title', 'Seller Requests')

@section('content')
<div class="p-6 space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 font-display">Seller Requests</h1>
            <p class="text-gray-600 mt-1">Manage and review seller applications</p>
        </div>
        <div class="mt-4 md:mt-0">
            <div class="bg-white px-4 py-2 rounded-xl border border-gray-200">
                <span class="text-sm text-gray-600">Total Requests:</span>
                <span class="text-lg font-bold text-primary ml-2">{{ $requests->total() }}</span>
            </div>
        </div>
    </div>

    <!-- Requests Table -->
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50/50 border-b border-gray-100 text-gray-400 uppercase text-[10px] font-bold tracking-widest">
                    <tr>
                        <th class="px-8 py-5">Applicant</th>
                        <th class="px-8 py-5">Contact Details</th>
                        <th class="px-8 py-5 text-center">Current Role</th>
                        <th class="px-8 py-5 text-center">Status</th>
                        <th class="px-8 py-5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($requests as $req)
                        <tr class="hover:bg-slate-50/50 transition-all duration-300 group">
                            <td class="px-8 py-6">
                                <div class="flex items-center space-x-4">
                                    <div class="relative">
                                        @if($req->user->profile_picture)
                                            <img src="{{ asset('storage/' . $req->user->profile_picture) }}"
                                                 class="w-12 h-12 rounded-2xl object-cover shadow-sm group-hover:shadow-md transition-all duration-300">
                                        @else
                                            <div class="w-12 h-12 rounded-2xl bg-linear-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold shadow-sm group-hover:shadow-md transition-all">
                                                {{ substr($req->user->name, 0, 1) }}
                                            </div>
                                        @endif
                                        <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 border-2 border-white rounded-full"></div>
                                    </div>
                                    <div>
                                        <span class="block font-bold text-slate-900 text-sm group-hover:text-indigo-600 transition-colors">{{ $req->user->name }}</span>
                                        <span class="text-[10px] text-gray-400 font-medium">Applied {{ $req->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="space-y-1">
                                    <span class="text-slate-600 text-xs block font-medium flex items-center">
                                        <i class="far fa-envelope mr-2 text-[10px] text-indigo-400"></i>
                                        {{ $req->user->email }}
                                    </span>
                                    <span class="text-slate-400 text-[11px] block flex items-center">
                                        <i class="fas fa-phone mr-2 text-[10px] text-pink-400"></i>
                                        {{ $req->phone_number }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-xl text-[10px] font-bold uppercase tracking-wider bg-slate-100 text-slate-600">
                                    {{ $req->user->role }}
                                </span>
                            </td>
                            <td class="px-8 py-6 text-center">
                                @if($req->status === 'pending')
                                    <span class="inline-flex items-center px-3 py-1 rounded-xl text-[10px] font-bold uppercase tracking-wider bg-amber-50 text-amber-600">
                                        <i class="fas fa-circle text-[6px] mr-2"></i>Pending Review
                                    </span>
                                @elseif($req->status === 'approved')
                                    <span class="inline-flex items-center px-3 py-1 rounded-xl text-[10px] font-bold uppercase tracking-wider bg-emerald-50 text-emerald-600">
                                        <i class="fas fa-check-circle mr-2"></i>Approved
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-xl text-[10px] font-bold uppercase tracking-wider bg-rose-50 text-rose-600">
                                        <i class="fas fa-times-circle mr-2"></i>Rejected
                                    </span>
                                @endif
                            </td>
                            <td class="px-8 py-6 text-right">
                                <div class="flex items-center justify-end space-x-3">
                                    <!-- View Details Button (Navigates to new page) -->
                                    <a href="{{ route('admin.seller-requests.show', $req->id) }}"
                                       class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center transition-all hover:bg-indigo-600 hover:text-white hover:shadow-lg hover:shadow-indigo-200 active:scale-90 group/btn cursor-pointer"
                                       title="View Full Details">
                                        <i class="far fa-eye text-sm group-hover/btn:scale-110 transition-transform"></i>
                                    </a>

                                    <!-- Delete Button -->
                                    <form id="delete-form-{{ $req->id }}" method="POST" action="{{ route('admin.seller-requests.delete', $req->id) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                                @click="$dispatch('confirm-modal', {
                                                    type: 'danger',
                                                    icon: 'fa-trash-alt',
                                                    title: 'Delete Request?',
                                                    message: 'Are you sure you want to permanently delete this request of {{ addslashes($req->user->name) }}? This cannot be undone.',
                                                    confirmText: 'Confirm Deletion',
                                                    formId: 'delete-form-{{ $req->id }}'
                                                })"
                                                class="w-10 h-10 bg-rose-50 text-rose-600 rounded-xl flex items-center justify-center transition-all hover:bg-rose-600 hover:text-white hover:shadow-lg hover:shadow-rose-100 active:scale-90 group/btn cursor-pointer"
                                                title="Delete Application">
                                            <i class="far fa-trash-alt text-sm group-hover/btn:scale-110 transition-transform"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-24 text-center">
                                <div class="max-w-xs mx-auto">
                                    <div class="w-20 h-20 bg-slate-50 text-slate-200 rounded-3xl flex items-center justify-center mx-auto mb-6 transform rotate-12">
                                        <i class="fas fa-inbox text-4xl"></i>
                                    </div>
                                    <h3 class="text-slate-900 font-bold text-lg">Inbox Zero!</h3>
                                    <p class="text-slate-400 text-sm mt-2">All caught up. No new seller applications to review at this moment.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($requests->hasPages())
        <div class="flex justify-center mt-8">
            {{ $requests->links() }}
        </div>
    @endif
</div>
@endsection
