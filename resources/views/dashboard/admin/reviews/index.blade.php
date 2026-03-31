@extends('layouts.dashboard')

@section('title', 'Reviews Management')

@section('content')
<div class="p-6 space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Product Reviews</h1>
            <div class="flex items-center gap-2 mt-1">
                <span class="text-sm text-slate-500">Manage customer opinions and verified ratings</span>
                <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                <span class="px-2 py-0.5 bg-slate-100 text-slate-600 text-[10px] font-bold uppercase rounded">Moderation</span>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <div class="px-4 py-2 bg-white rounded-xl shadow-sm border border-slate-100 flex items-center gap-3">
                <div class="w-8 h-8 bg-orange-100 text-orange-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-star text-xs"></i>
                </div>
                <div>
                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Feedback</div>
                    <div class="text-sm font-bold text-slate-900">{{ App\Models\Review::count() }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews Table -->
    <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 overflow-hidden border border-slate-100">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50/50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Customer</th>
                        <th class="px-6 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Product Info</th>
                        <th class="px-6 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Rating</th>
                        <th class="px-6 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">User Comment</th>
                        <th class="px-6 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Moderation Status</th>
                        <th class="px-6 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Date</th>
                        <th class="px-6 py-5 text-right text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($reviews as $review)
                    <tr class="hover:bg-slate-50/80 transition-all group">
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center font-black text-sm ring-4 ring-orange-50/50">
                                    {{ substr($review->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-black text-slate-900 truncate max-w-[120px]">{{ $review->user->name }}</div>
                                    <div class="text-[10px] font-bold text-slate-400 truncate max-w-[120px] italic">{{ $review->user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="text-xs font-black text-slate-900 uppercase tracking-tight">{{ $review->product->name }}</div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex text-yellow-400 text-[10px] bg-yellow-400/5 px-3 py-1.5 rounded-full border border-yellow-400/10 inline-flex">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star"></i>
                                @endfor
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="text-xs text-slate-600 max-w-xs line-clamp-2 leading-relaxed" title="{{ $review->comment }}">
                                {{ $review->comment }}
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            @if($review->status === 'approved')
                                <span class="px-3 py-1 bg-green-50 text-green-600 rounded-lg text-[9px] font-black uppercase tracking-widest border border-green-100 italic">Verified</span>
                            @elseif($review->status === 'pending')
                                <span class="px-3 py-1 bg-amber-50 text-amber-600 rounded-lg text-[9px] font-black uppercase tracking-widest border border-amber-100 italic">Awaiting</span>
                            @else
                                <span class="px-3 py-1 bg-rose-50 text-rose-600 rounded-lg text-[9px] font-black uppercase tracking-widest border border-rose-100 italic">Rejected</span>
                            @endif
                        </td>
                        <td class="px-6 py-5">
                            <div class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">
                                {{ $review->created_at->format('M d, Y') }}
                            </div>
                        </td>
                        <td class="px-6 py-5 text-right">
                            <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                @if($review->status !== 'approved')
                                <form action="{{ route('admin.reviews.approve', $review) }}" method="POST">
                                    @csrf
                                    <button type="submit" 
                                            class="w-8 h-8 flex items-center justify-center bg-white text-green-600 rounded-lg border border-slate-200 hover:bg-green-600 hover:text-white hover:border-green-600 transition-all shadow-sm"
                                            title="Approve">
                                        <i class="fas fa-check text-[10px]"></i>
                                    </button>
                                </form>
                                @endif

                                @if($review->status !== 'rejected')
                                <form action="{{ route('admin.reviews.reject', $review) }}" method="POST">
                                    @csrf
                                    <button type="submit" 
                                            class="w-8 h-8 flex items-center justify-center bg-white text-rose-600 rounded-lg border border-slate-200 hover:bg-rose-600 hover:text-white hover:border-rose-600 transition-all shadow-sm"
                                            title="Reject">
                                        <i class="fas fa-times text-[10px]"></i>
                                    </button>
                                </form>
                                @endif

                                <button @click="$dispatch('confirm-modal', {
                                            type: 'danger',
                                            icon: 'fa-trash-alt',
                                            title: 'Permanently Delete?',
                                            message: 'This review will be permanently removed from the system.',
                                            confirmText: 'Delete Feedback',
                                            formId: 'deleteReviewForm{{ $review->id }}'
                                        })"
                                        class="w-8 h-8 flex items-center justify-center bg-white text-slate-400 rounded-lg border border-slate-200 hover:bg-slate-900 hover:text-white hover:border-slate-900 transition-all shadow-sm"
                                        title="Delete">
                                    <i class="fas fa-trash-alt text-[10px]"></i>
                                </button>
                                <form id="deleteReviewForm{{ $review->id }}"
                                      action="{{ route('admin.reviews.destroy', $review) }}"
                                      method="POST"
                                      class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-32 text-center bg-slate-50/50">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center mb-6 shadow-xl shadow-slate-200/50">
                                    <i class="fas fa-comment-slash text-2xl text-slate-200"></i>
                                </div>
                                <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight">No Reviews to moderate</h3>
                                <p class="text-slate-400 text-sm max-w-xs mx-auto mt-2 leading-relaxed italic">Your customers haven't shared their opinions yet. They will appear here once submitted.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($reviews->hasPages())
        <div class="px-6 py-6 border-t border-slate-100 bg-slate-50/30">
            {{ $reviews->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
