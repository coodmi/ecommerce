@extends('layouts.app')

@section('title', 'Checkout')

@section('content')

<!-- Breadcrumb -->
<div class="bg-gray-50 border-b border-gray-100 py-3">
    <div class="container mx-auto px-4">
        <nav class="flex items-center gap-2 text-xs text-gray-500">
            <a href="/" class="hover:text-primary transition">Home</a>
            <i class="fas fa-chevron-right text-[9px]"></i>
            <a href="{{ route('cart.index') }}" class="hover:text-primary transition">Cart</a>
            <i class="fas fa-chevron-right text-[9px]"></i>
            <span class="text-gray-800 font-medium">Checkout</span>
        </nav>
    </div>
</div>

<div class="container mx-auto px-4 py-8 pb-16" x-data="checkoutForm()">

    <h1 class="text-xl font-bold text-gray-900 mb-6">Checkout</h1>

    <div class="flex flex-col lg:flex-row gap-8 items-start">

        {{-- Left: Form --}}
        <div class="flex-1 min-w-0 w-full space-y-5">

            {{-- Shipping Info --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="flex items-center gap-3 px-5 py-4 border-b border-gray-50">
                    <div class="w-7 h-7 bg-primary text-white rounded-lg flex items-center justify-center text-xs font-bold flex-shrink-0">1</div>
                    <h2 class="text-sm font-bold text-gray-800">Shipping Information</h2>
                </div>
                <div class="p-5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($fields as $field)
                        <div class="{{ $field->type === 'textarea' ? 'sm:col-span-2' : '' }}">
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                                {{ $field->label }}@if($field->is_required)<span class="text-red-500 ml-0.5">*</span>@endif
                            </label>
                            @if($field->type === 'textarea')
                                <textarea name="{{ $field->name }}" x-model="formData.{{ $field->name }}"
                                          {{ $field->is_required ? 'required' : '' }} rows="3"
                                          placeholder="{{ $field->placeholder }}"
                                          class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-primary focus:bg-white transition resize-none"></textarea>
                            @elseif($field->type === 'select')
                                <select name="{{ $field->name }}" x-model="formData.{{ $field->name }}"
                                        {{ $field->is_required ? 'required' : '' }}
                                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 focus:outline-none focus:border-primary focus:bg-white transition">
                                    <option value="">Select {{ $field->label }}</option>
                                    @foreach($field->options as $option)
                                        <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                            @else
                                <input type="{{ $field->type }}" name="{{ $field->name }}"
                                       x-model="formData.{{ $field->name }}"
                                       {{ $field->is_required ? 'required' : '' }}
                                       placeholder="{{ $field->placeholder }}"
                                       class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-primary focus:bg-white transition">
                            @endif
                            <template x-if="errors.{{ $field->name }}">
                                <p class="text-red-500 text-xs mt-1" x-text="errors.{{ $field->name }}[0]"></p>
                            </template>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Payment Method --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="flex items-center gap-3 px-5 py-4 border-b border-gray-50">
                    <div class="w-7 h-7 bg-primary text-white rounded-lg flex items-center justify-center text-xs font-bold flex-shrink-0">2</div>
                    <h2 class="text-sm font-bold text-gray-800">Payment Method</h2>
                </div>
                <div class="p-5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <label class="flex items-center gap-3 p-4 bg-primary/5 border-2 border-primary rounded-xl cursor-pointer">
                            <input type="radio" name="payment_method" value="cod" checked class="hidden">
                            <div class="w-9 h-9 bg-primary/10 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-truck text-primary text-sm"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-gray-800">Cash on Delivery</p>
                                <p class="text-xs text-gray-400">Pay when you receive</p>
                            </div>
                            <i class="fas fa-check-circle text-primary"></i>
                        </label>
                        <div class="flex items-center gap-3 p-4 bg-gray-50 border-2 border-gray-100 rounded-xl opacity-50 cursor-not-allowed">
                            <div class="w-9 h-9 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-credit-card text-gray-400 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-400">Online Payment</p>
                                <p class="text-xs text-gray-400">Coming Soon</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Place Order Button mobile --}}
            <button type="button" @click="submitOrder()" :disabled="isSubmitting"
                    class="lg:hidden w-full bg-primary hover:bg-primary/90 text-white py-4 rounded-xl font-bold text-sm transition shadow-sm disabled:opacity-60">
                <span x-text="isSubmitting ? 'Processing...' : 'Place Order Now'"></span>
            </button>
        </div>

        {{-- Right: Summary --}}
        <div class="w-full lg:w-[360px] lg:flex-shrink-0">
            <div class="bg-primary rounded-2xl p-6 text-white lg:sticky lg:top-24">
                <h2 class="text-sm font-bold uppercase tracking-wider mb-5 pb-4 border-b border-white/20">Order Summary</h2>

                {{-- Items --}}
                <div class="space-y-3 mb-5 max-h-48 overflow-y-auto pr-1">
                    @foreach($cart as $item)
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-lg overflow-hidden bg-white/10 flex-shrink-0">
                            <img src="{{ $item['image'] ? (str_starts_with($item['image'], 'http') ? $item['image'] : asset('storage/' . $item['image'])) : asset('images/placeholder-product.jpg') }}"
                                 class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-semibold truncate">{{ $item['name'] }}</p>
                            <p class="text-xs text-white/60 mt-0.5">{{ $item['quantity'] }} × ${{ number_format($item['price'], 2) }}</p>
                        </div>
                        <span class="text-sm font-bold flex-shrink-0">${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                    </div>
                    @endforeach
                </div>

                {{-- Totals --}}
                <div class="space-y-2.5 pt-4 border-t border-white/20 mb-4">
                    <div class="flex justify-between text-sm">
                        <span class="text-white/70">Subtotal</span>
                        <span class="font-semibold">${{ number_format($total, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-white/70">{{ $deliveryLabel }}</span>
                        @if($shipping > 0)
                            <span class="font-semibold">${{ number_format($shipping, 2) }}</span>
                        @else
                            <span class="font-bold text-yellow-300">FREE</span>
                        @endif
                    </div>
                </div>

                <div class="flex justify-between items-center py-4 border-t border-b border-white/20 mb-5">
                    <span class="text-white/80 text-sm font-medium">Total</span>
                    <span class="text-2xl font-bold">${{ number_format($grandTotal, 2) }}</span>
                </div>

                {{-- Place Order desktop --}}
                <button type="button" @click="submitOrder()" :disabled="isSubmitting"
                        class="hidden lg:block w-full bg-white text-primary hover:bg-white/90 py-3.5 rounded-xl font-bold text-sm text-center transition shadow-sm disabled:opacity-60">
                    <span x-text="isSubmitting ? 'Processing...' : 'Place Order Now'"></span>
                </button>

                <div class="mt-4 flex items-center justify-center gap-2 text-white/30">
                    <i class="fas fa-shield-alt text-sm"></i>
                    <span class="text-xs">Secure & encrypted checkout</span>
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
                        detail: { type: 'success', title: 'Order Placed!', message: data.message }
                    }));
                    setTimeout(() => { window.location.href = data.redirect; }, 1500);
                } else if (data.errors) {
                    this.errors = data.errors;
                    window.dispatchEvent(new CustomEvent('toast', {
                        detail: { type: 'error', title: 'Check the form', message: 'Please fix the errors below.' }
                    }));
                } else {
                    window.dispatchEvent(new CustomEvent('toast', {
                        detail: { type: 'error', message: data.message || 'Something went wrong.' }
                    }));
                }
            })
            .catch(() => {
                window.dispatchEvent(new CustomEvent('toast', {
                    detail: { type: 'error', message: 'Network error. Please try again.' }
                }));
            })
            .finally(() => { this.isSubmitting = false; });
        }
    }
}
</script>
@endpush
@endsection
