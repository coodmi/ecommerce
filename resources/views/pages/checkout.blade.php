@extends('layouts.app')

@section('title', 'Checkout - Ecom Alpha')

@section('content')
<!-- Breadcrumb -->
<section class="bg-slate-50 border-b border-slate-200 py-6 mb-12">
    <div class="container mx-auto px-4">
        <nav class="flex items-center space-x-2 text-sm font-medium">
            <a href="/" class="text-slate-500 hover:text-primary transition">Home</a>
            <i class="fas fa-chevron-right text-[10px] text-slate-300"></i>
            <a href="{{ route('cart.index') }}" class="text-slate-500 hover:text-primary transition">Cart</a>
            <i class="fas fa-chevron-right text-[10px] text-slate-300"></i>
            <span class="text-slate-900">Checkout</span>
        </nav>
    </div>
</section>

<div class="container mx-auto px-4 pb-20" x-data="checkoutForm()">
    <div class="flex flex-col lg:flex-row gap-12">
        <!-- Checkout Form -->
        <div class="lg:w-2/3">
            <h1 class="text-4xl font-black text-slate-900 uppercase tracking-tight mb-8">Checkout</h1>
            
            <form @submit.prevent="submitOrder" class="space-y-8">
                <div class="bg-white rounded-[3rem] p-10 border border-slate-100 shadow-sm">
                    <h2 class="text-2xl font-black text-slate-900 uppercase tracking-widest mb-8 flex items-center gap-4">
                        <span class="w-10 h-10 bg-primary text-white rounded-xl flex items-center justify-center text-sm">01</span>
                        Shipping Information
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($fields as $field)
                        <div class="space-y-2 {{ $field->type === 'textarea' ? 'md:col-span-2' : '' }}">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] ml-1">
                                {{ $field->label }} @if($field->is_required)<span class="text-rose-500">*</span>@endif
                            </label>
                            
                            @if($field->type === 'textarea')
                                <textarea name="{{ $field->name }}" x-model="formData.{{ $field->name }}"
                                          {{ $field->is_required ? 'required' : '' }}
                                          class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-50 rounded-2xl focus:border-primary focus:bg-white transition-all outline-none text-slate-900 font-bold placeholder:text-slate-300"
                                          placeholder="{{ $field->placeholder }}" rows="4"></textarea>
                            @elseif($field->type === 'select')
                                <select name="{{ $field->name }}" x-model="formData.{{ $field->name }}"
                                        {{ $field->is_required ? 'required' : '' }}
                                        class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-50 rounded-2xl focus:border-primary focus:bg-white transition-all outline-none text-slate-900 font-bold">
                                    <option value="">Select {{ $field->label }}</option>
                                    @foreach($field->options as $option)
                                        <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                            @else
                                <input type="{{ $field->type }}" name="{{ $field->name }}" x-model="formData.{{ $field->name }}"
                                       {{ $field->is_required ? 'required' : '' }}
                                       class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-50 rounded-2xl focus:border-primary focus:bg-white transition-all outline-none text-slate-900 font-bold placeholder:text-slate-300"
                                       placeholder="{{ $field->placeholder }}">
                            @endif
                            <template x-if="errors.{{ $field->name }}">
                                <p class="text-rose-500 text-[10px] font-bold uppercase tracking-wider mt-1" x-text="errors.{{ $field->name }}[0]"></p>
                            </template>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-white rounded-[3rem] p-10 border border-slate-100 shadow-sm">
                    <h2 class="text-2xl font-black text-slate-900 uppercase tracking-widest mb-8 flex items-center gap-4">
                        <span class="w-10 h-10 bg-primary text-white rounded-xl flex items-center justify-center text-sm">02</span>
                        Payment Method
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <label class="relative flex items-center p-6 bg-slate-50 rounded-2xl border-2 border-primary cursor-pointer transition-all">
                            <input type="radio" name="payment_method" value="cod" checked class="hidden">
                            <i class="fas fa-truck text-primary text-2xl mr-4"></i>
                            <div>
                                <p class="font-black text-slate-900 uppercase tracking-widest text-sm">Cash on Delivery</p>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Pay when you receive</p>
                            </div>
                            <i class="fas fa-check-circle text-primary ml-auto"></i>
                        </label>
                        
                        <div class="relative flex items-center p-6 bg-slate-50 rounded-2xl border-2 border-slate-100 opacity-50 cursor-not-allowed">
                            <i class="fas fa-credit-card text-slate-400 text-2xl mr-4"></i>
                            <div>
                                <p class="font-black text-slate-400 uppercase tracking-widest text-sm">Online Payment</p>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Coming Soon</p>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" :disabled="isSubmitting"
                        class="w-full bg-slate-900 hover:bg-slate-800 text-white py-6 rounded-[2rem] font-black uppercase tracking-[0.3em] transition-all duration-500 transform hover:scale-[1.02] shadow-2xl relative overflow-hidden group">
                    <span class="relative z-10" x-text="isSubmitting ? 'Processing...' : 'Place Order Now'"></span>
                    <div class="absolute inset-0 bg-linear-to-r from-primary to-primary/80 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                </button>
            </form>
        </div>

        <!-- Summary -->
        <div class="lg:w-1/3">
            <div class="bg-slate-900 rounded-[3rem] p-10 text-white sticky top-24 shadow-2xl">
                <h2 class="text-2xl font-black uppercase tracking-tight mb-8">Summary</h2>
                
                <div class="space-y-6 mb-8 max-h-60 overflow-y-auto pr-2 custom-scrollbar">
                    @foreach($cart as $item)
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-xl overflow-hidden bg-white/10 flex-shrink-0">
                            <img src="{{ $item['image'] ? (str_starts_with($item['image'], 'http') ? $item['image'] : asset('storage/' . $item['image'])) : asset('images/placeholder-product.jpg') }}" 
                                 class="w-full h-full object-cover opacity-80">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-bold text-xs uppercase tracking-widest truncate">{{ $item['name'] }}</p>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mt-1">{{ $item['quantity'] }} x ${{ number_format($item['price'], 2) }}</p>
                        </div>
                        <span class="font-black text-sm">${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                    </div>
                    @endforeach
                </div>

                <div class="space-y-4 mb-8 pt-8 border-t border-white/10">
                    <div class="flex justify-between text-slate-400">
                        <span class="font-bold uppercase tracking-widest text-[10px]">Subtotal</span>
                        <span class="font-black text-sm">${{ number_format($total, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-slate-400 text-[10px]">
                        <span class="font-bold uppercase tracking-widest">Shipping</span>
                        <span class="font-black text-emerald-400 uppercase">Free</span>
                    </div>
                </div>

                <div class="flex justify-between items-end mb-10 pt-10 border-t border-white/10">
                    <span class="text-slate-400 font-bold uppercase tracking-[0.2em] text-xs">Total</span>
                    <span class="text-4xl font-black">${{ number_format($total, 2) }}</span>
                </div>

                <div class="bg-white/5 rounded-2xl p-6 border border-white/5">
                    <div class="flex items-center gap-4 text-slate-400 text-[10px] font-bold uppercase tracking-widest">
                        <i class="fas fa-shield-halved text-primary text-lg"></i>
                        Secure checkout & encrypted payment processing
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function checkoutForm() {
    return {
        formData: {
            @foreach($fields as $field)
                '{{ $field->name }}': '',
            @endforeach
        },
        errors: {},
        isSubmitting: false,

        submitOrder() {
            this.isSubmitting = true;
            this.errors = {};

            fetch('{{ route('checkout.store') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(this.formData)
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    window.dispatchEvent(new CustomEvent('toast', {
                        detail: { 
                            type: 'success', 
                            title: 'Order Placed!', 
                            message: data.message 
                        }
                    }));
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 2000);
                } else if (data.errors) {
                    this.errors = data.errors;
                    window.dispatchEvent(new CustomEvent('toast', {
                        detail: { 
                            type: 'error', 
                            title: 'Validation Failed', 
                            message: 'Please check the form for errors.' 
                        }
                    }));
                } else {
                    window.dispatchEvent(new CustomEvent('toast', {
                        detail: { 
                            type: 'error', 
                            message: data.message || 'Something went wrong.' 
                        }
                    }));
                }
            })
            .catch(err => {
                console.error(err);
            })
            .finally(() => {
                this.isSubmitting = false;
            });
        }
    }
}
</script>

<style>
.custom-scrollbar::-webkit-scrollbar {
    width: 4px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.05);
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 10px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.2);
}
</style>
@endpush
@endsection
