@extends('layouts.app')

@section('title', 'My Reviews - Ecom Alpha')

@section('content')
<div class="flex h-screen bg-slate-50">
    <!-- User Sidebar -->
    <x-sidebar-user />

    <main class="flex-1 overflow-y-auto p-8">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-black text-slate-900 uppercase tracking-tight">My Reviews</h1>
                <p class="text-slate-500 mt-1">Manage and view your product feedback</p>
            </div>
        </div>

        <div class="space-y-6">
            @forelse($reviews as $review)
            <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-slate-100 hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-500 group">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="flex items-center gap-6">
                        <div class="w-20 h-20 rounded-2xl overflow-hidden bg-slate-50 border border-slate-100">
                            @if($review->product->primaryImage)
                                <img src="{{ $review->product->primaryImage->url }}" class="w-full h-full object-cover" alt="{{ $review->product->name }}">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-300">
                                    <i class="fas fa-image text-2xl"></i>
                                </div>
                            @endif
                        </div>
                        <div>
                            <h3 class="font-black text-slate-900 uppercase tracking-tight group-hover:text-primary transition-colors cursor-pointer" onclick="window.location='{{ route('product.details', $review->product->slug) }}'">
                                {{ $review->product->name }}
                            </h3>
                            <div class="flex items-center gap-3 mt-2">
                                <div class="flex text-yellow-400 text-[10px]">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star"></i>
                                    @endfor
                                </div>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $review->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-4">
                        @if($review->status === 'approved')
                            <span class="px-4 py-1.5 bg-emerald-50 text-emerald-600 rounded-full text-[10px] font-black uppercase tracking-widest border border-emerald-100 italic">Approved</span>
                        @elseif($review->status === 'pending')
                            <span class="px-4 py-1.5 bg-amber-50 text-amber-600 rounded-full text-[10px] font-black uppercase tracking-widest border border-amber-100 italic">Pending Approval</span>
                        @else
                            <span class="px-4 py-1.5 bg-rose-50 text-rose-600 rounded-full text-[10px] font-black uppercase tracking-widest border border-rose-100 italic">Rejected</span>
                        @endif
                    </div>
                </div>
                
                <div class="mt-6 p-6 bg-slate-50 rounded-2xl border border-slate-100 text-slate-600 text-sm leading-relaxed">
                    {{ $review->comment }}
                </div>
            </div>
            @empty
            <div class="text-center py-20 bg-white rounded-[3rem] border border-dashed border-slate-200">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-comment-dots text-slate-300 text-3xl"></i>
                </div>
                <h2 class="text-2xl font-black text-slate-900 uppercase tracking-tight mb-2">No reviews yet</h2>
                <p class="text-slate-500 mb-8 max-w-sm mx-auto">You haven't shared your opinion on any products yet. Start shopping and tell us what you think!</p>
                <a href="{{ route('shop') }}" class="inline-flex items-center justify-center px-10 py-4 bg-slate-900 text-white font-black rounded-2xl shadow-xl shadow-slate-200 transition-all hover:bg-slate-800 uppercase tracking-widest text-xs">
                    Browse Products
                </a>
            </div>
            @endforelse

            <div class="mt-8">
                {{ $reviews->links() }}
            </div>
        </div>
    </main>
</div>
@endsection
