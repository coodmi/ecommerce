@extends('layouts.dashboard')

@section('title', 'Request Details - ' . $request->user->name)

@section('content')
<div class="p-6 space-y-8 max-w-6xl mx-auto">
    <!-- Breadcrumbs / Back Link -->
    <div class="flex items-center space-x-4">
        <a href="{{ route('admin.seller-requests') }}" class="w-10 h-10 bg-white border border-gray-200 rounded-xl flex items-center justify-center text-gray-500 hover:text-indigo-600 hover:border-indigo-100 transition-all hover:shadow-sm group cursor-pointer">
            <i class="fas fa-chevron-left text-sm group-hover:-translate-x-1 transition-transform"></i>
        </a>
        <div>
            <nav class="flex text-sm text-gray-500 mb-1">
                <a href="{{ route('admin.seller-requests') }}" class="hover:text-indigo-600 cursor-pointer">Requests</a>
                <span class="mx-2">/</span>
                <span class="text-gray-900 font-medium">Application Info</span>
            </nav>
            <h1 class="text-2xl font-bold text-gray-900 font-display">Seller Application Review</h1>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Sidebar: Applicant Profile & Actions -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8 text-center relative overflow-hidden">
                <!-- Status Badge (Floating) -->
                <div class="absolute top-6 right-8">
                    @if($request->status === 'pending')
                        <span class="px-3 py-1 bg-amber-50 text-amber-600 rounded-full text-[10px] font-bold uppercase tracking-widest">Pending</span>
                    @elseif($request->status === 'approved')
                        <span class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full text-[10px] font-bold uppercase tracking-widest">Approved</span>
                    @else
                        <span class="px-3 py-1 bg-rose-50 text-rose-600 rounded-full text-[10px] font-bold uppercase tracking-widest">Rejected</span>
                    @endif
                </div>

                <div class="relative w-24 h-24 mx-auto mb-6">
                    @if($request->user->profile_picture)
                        <img src="{{ asset('storage/' . $request->user->profile_picture) }}" 
                             class="w-full h-full rounded-[2rem] object-cover shadow-xl border-4 border-white">
                    @else
                        <div class="w-full h-full rounded-[2rem] bg-linear-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-3xl font-bold text-white shadow-xl border-4 border-white">
                            {{ substr($request->user->name, 0, 1) }}
                        </div>
                    @endif
                    <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-green-500 border-4 border-white rounded-full"></div>
                </div>

                <h2 class="text-xl font-bold text-slate-900">{{ $request->user->name }}</h2>
                <p class="text-gray-400 text-sm mb-4">{{ $request->user->email }}</p>
                
                <div class="inline-flex items-center px-4 py-2 bg-slate-50 rounded-2xl text-[11px] font-bold text-slate-500 uppercase tracking-widest border border-slate-100">
                    <i class="fas fa-shield-alt mr-2 text-indigo-400"></i> {{ $request->user->role }}
                </div>

                <div class="mt-8 pt-8 border-t border-slate-50 flex items-center justify-between text-left">
                    <div>
                        <span class="text-[10px] text-gray-400 uppercase font-bold block mb-1">Joined Date</span>
                        <span class="text-sm font-bold text-slate-700">{{ $request->user->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Approval/Rejection Actions -->
            @if($request->status === 'pending')
                <div class="bg-indigo-900 rounded-[2rem] p-8 shadow-2xl shadow-indigo-100 text-white space-y-6">
                    <h3 class="text-lg font-bold font-display">Decision Required</h3>
                    <p class="text-indigo-200 text-xs leading-relaxed">Please review the business details provided before granting merchant access. This user will receive a notification of your decision.</p>
                    
                    <div class="space-y-3">
                        <form id="approve-form" method="POST" action="{{ route('admin.seller-requests.approve', $request->id) }}">
                            @csrf
                            <button type="button" 
                                    @click="$dispatch('confirm-modal', {
                                        type: 'info',
                                        icon: 'fa-check-circle',
                                        title: 'Approve Application?',
                                        message: 'This will grant the user seller privileges. They will be notified via email.',
                                        confirmText: 'Approve Now',
                                        formId: 'approve-form'
                                    })"
                                    class="w-full py-4 bg-white text-indigo-600 rounded-2xl font-bold hover:bg-opacity-90 transition-all flex items-center justify-center shadow-lg shadow-black/10 active:scale-95 cursor-pointer">
                                <i class="fas fa-check-circle mr-2"></i>Approve Application
                            </button>
                        </form>

                        <form id="reject-form" method="POST" action="{{ route('admin.seller-requests.reject', $request->id) }}">
                            @csrf
                            <button type="button" 
                                    @click="$dispatch('confirm-modal', {
                                        type: 'warning',
                                        icon: 'fa-times-circle',
                                        title: 'Reject Application?',
                                        message: 'Are you sure you want to deny this request? They can re-apply in the future.',
                                        confirmText: 'Reject Application',
                                        formId: 'reject-form'
                                    })"
                                    class="w-full py-4 bg-transparent border-2 border-indigo-400 text-white rounded-2xl font-bold hover:bg-indigo-800 transition-all flex items-center justify-center active:scale-95 cursor-pointer">
                                <i class="fas fa-times-circle mr-2"></i>Reject
                            </button>
                        </form>
                    </div>
                </div>
            @endif

            <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8 space-y-4">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest border-b border-gray-100 pb-3">Review History</h3>
                <div class="space-y-4">
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600 text-xs mt-1">
                            <i class="fas fa-paper-plane"></i>
                        </div>
                        <div>
                            <p class="text-[11px] font-bold text-slate-900">Application Submitted</p>
                            <span class="text-[10px] text-gray-400">{{ $request->created_at->format('M d, Y \a\t h:i A') }}</span>
                        </div>
                    </div>
                    @if($request->reviewed_at)
                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-600 text-xs mt-1">
                                <i class="fas fa-check"></i>
                            </div>
                            <div>
                                <p class="text-[11px] font-bold text-slate-900">Decision Made ({{ $request->status }})</p>
                                <span class="text-[10px] text-gray-400">{{ $request->reviewed_at->format('M d, Y \a\t h:i A') }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Main Content: Data Sections -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Personal Data -->
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-10 space-y-8">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                        <i class="fas fa-user-tie text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-900 font-display">Identity Information</h3>
                        <p class="text-xs text-gray-400 leading-none mt-1">Full legal details provided by the applicant.</p>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-10">
                    <div class="space-y-2">
                        <label class="text-[10px] text-gray-400 font-bold uppercase tracking-widest block">Legal Full Name</label>
                        <p class="text-slate-900 font-bold text-base bg-slate-50 px-5 py-4 rounded-2xl border border-slate-100">{{ $request->full_name }}</p>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] text-gray-400 font-bold uppercase tracking-widest block">Primary Phone</label>
                        <p class="text-slate-900 font-bold text-base bg-slate-50 px-5 py-4 rounded-2xl border border-slate-100 flex items-center">
                            <i class="fas fa-phone mr-3 text-indigo-400 text-xs"></i>
                            {{ $request->phone_number }}
                        </p>
                    </div>
                    <div class="md:col-span-2 space-y-2">
                        <label class="text-[10px] text-gray-400 font-bold uppercase tracking-widest block">Permanent Address</label>
                        <div class="bg-slate-50 px-6 py-5 rounded-2xl border border-slate-100 text-slate-700 leading-relaxed text-sm italic">
                            {{ $request->address }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Business Data -->
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-10 space-y-8 relative overflow-hidden">
                <!-- Decorative Element -->
                <div class="absolute top-0 right-0 p-8 transform translate-x-1/3 -translate-y-1/3">
                    <i class="fas fa-store text-[120px] text-gray-50 opacity-50"></i>
                </div>

                <div class="relative flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-2xl bg-pink-50 flex items-center justify-center text-pink-600">
                        <i class="fas fa-store text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-900 font-display">Business & Store Info</h3>
                        <p class="text-xs text-gray-400 leading-none mt-1">Trade details and operational branding.</p>
                    </div>
                </div>

                <div class="relative grid md:grid-cols-2 gap-10">
                    <div class="space-y-2">
                        <label class="text-[10px] text-gray-400 font-bold uppercase tracking-widest block">Business Trade Name</label>
                        <p class="text-slate-900 font-bold text-base bg-pink-50/30 px-5 py-4 rounded-2xl border border-pink-100/50">{{ $request->business_name }}</p>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] text-gray-400 font-bold uppercase tracking-widest block">Business Contact</label>
                        <p class="text-slate-900 font-bold text-base bg-pink-50/30 px-5 py-4 rounded-2xl border border-pink-100/50 flex items-center">
                            <i class="fas fa-phone-alt mr-3 text-pink-400 text-xs"></i>
                            {{ $request->business_phone_number }}
                        </p>
                    </div>
                    <div class="md:col-span-2 space-y-2">
                        <label class="text-[10px] text-gray-400 font-bold uppercase tracking-widest block">Store Address</label>
                        <div class="bg-pink-50/30 px-6 py-5 rounded-2xl border border-pink-100/50 text-slate-700 leading-relaxed text-sm">
                            {{ $request->business_address }}
                        </div>
                    </div>
                </div>

                <div class="relative space-y-2">
                    <label class="text-[10px] text-gray-400 font-bold uppercase tracking-widest block">Detailed Description of Products</label>
                    <div class="bg-slate-900 rounded-[2rem] p-8 text-indigo-100 leading-relaxed text-sm font-medium shadow-2xl">
                        <i class="fas fa-quote-left text-indigo-500/30 text-3xl mb-4 block"></i>
                        {{ $request->business_description }}
                    </div>
                </div>
            </div>

            <!-- Additional Note -->
            @if($request->message)
                <div class="bg-emerald-50/30 rounded-[2.5rem] border border-emerald-100 p-10 space-y-4">
                    <h3 class="text-xs font-bold text-emerald-600 uppercase tracking-widest flex items-center">
                        <i class="fas fa-envelope-open-text mr-3"></i> Note from Applicant
                    </h3>
                    <p class="text-slate-700 leading-relaxed text-sm">{{ $request->message }}</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
