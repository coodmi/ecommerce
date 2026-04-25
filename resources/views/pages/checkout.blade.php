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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

        {{-- Left: Form (takes 2 cols) --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Contact Information --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                    <h2 class="text-sm font-bold text-gray-900">Contact Information</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @php
                            $contactFields = collect($fields)->filter(fn($f) => in_array($f->name, ['full_name', 'phone', 'email']))->values();
                        @endphp
                        @foreach($contactFields as $field)
                        <div class="{{ $field->name === 'email' ? 'sm:col-span-2' : '' }}">
                            <label class="block text-xs font-semibold text-gray-700 mb-2">
                                {{ $field->label }}@if($field->is_required)<span class="text-red-500">*</span>@endif
                            </label>
                            @if($field->type === 'textarea')
                                <textarea name="{{ $field->name }}" x-model="formData.{{ $field->name }}"
                                          {{ $field->is_required ? 'required' : '' }} rows="3"
                                          placeholder="{{ $field->placeholder }}"
                                          class="w-full px-4 py-3 border border-gray-200 rounded-lg text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition resize-none"></textarea>
                            @elseif($field->type === 'select')
                                <select name="{{ $field->name }}" x-model="formData.{{ $field->name }}"
                                        {{ $field->is_required ? 'required' : '' }}
                                        class="w-full px-4 py-3 border border-gray-200 rounded-lg text-sm text-gray-800 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition">
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
                                       class="w-full px-4 py-3 border border-gray-200 rounded-lg text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition">
                            @endif
                            <template x-if="errors.{{ $field->name }}">
                                <p class="text-red-500 text-xs mt-1" x-text="errors.{{ $field->name }}[0]"></p>
                            </template>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Shipping Address --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                    <h2 class="text-sm font-bold text-gray-900">Shipping Address</h2>
                </div>
                <div class="p-6 space-y-5">
                    {{-- Delivery Zone Selection --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-3">Delivery Zone <span class="text-red-500">*</span></label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <label class="relative cursor-pointer group">
                                <input type="radio" name="delivery_zone" value="inside_dhaka" x-model="formData.delivery_zone" class="hidden peer" required>
                                <div class="p-4 border-2 border-gray-200 rounded-lg peer-checked:border-primary peer-checked:bg-primary/5 transition hover:border-gray-300">
                                    <div class="flex items-start gap-3">
                                        <div class="w-5 h-5 rounded-full border-2 border-gray-300 peer-checked:border-primary peer-checked:bg-primary flex items-center justify-center flex-shrink-0 mt-0.5">
                                            <i class="fas fa-check text-white text-xs hidden peer-checked:block"></i>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-1">
                                                <i class="fas fa-map-marker-alt text-primary text-sm"></i>
                                                <p class="font-semibold text-gray-900 text-sm">Inside Dhaka</p>
                                            </div>
                                            <p class="text-xs text-gray-500">Delivery within 1-2 days</p>
                                        </div>
                                        <span class="text-primary font-bold text-sm">৳80</span>
                                    </div>
                                </div>
                            </label>
                            <label class="relative cursor-pointer group">
                                <input type="radio" name="delivery_zone" value="outside_dhaka" x-model="formData.delivery_zone" class="hidden peer" required>
                                <div class="p-4 border-2 border-gray-200 rounded-lg peer-checked:border-primary peer-checked:bg-primary/5 transition hover:border-gray-300">
                                    <div class="flex items-start gap-3">
                                        <div class="w-5 h-5 rounded-full border-2 border-gray-300 peer-checked:border-primary peer-checked:bg-primary flex items-center justify-center flex-shrink-0 mt-0.5">
                                            <i class="fas fa-check text-white text-xs hidden peer-checked:block"></i>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-1">
                                                <i class="fas fa-truck text-primary text-sm"></i>
                                                <p class="font-semibold text-gray-900 text-sm">Outside Dhaka</p>
                                            </div>
                                            <p class="text-xs text-gray-500">Delivery within 3-5 days</p>
                                        </div>
                                        <span class="text-primary font-bold text-sm">৳140</span>
                                    </div>
                                </div>
                            </label>
                        </div>
                        <template x-if="errors.delivery_zone">
                            <p class="text-red-500 text-xs mt-2" x-text="errors.delivery_zone[0]"></p>
                        </template>
                    </div>

                    {{-- Address Fields --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-2">Full Address <span class="text-red-500">*</span></label>
                        <textarea name="full_address" x-model="formData.full_address" required rows="3"
                                  placeholder="Enter your complete delivery address"
                                  class="w-full px-4 py-3 border border-gray-200 rounded-lg text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition resize-none"></textarea>
                        <template x-if="errors.full_address">
                            <p class="text-red-500 text-xs mt-1" x-text="errors.full_address[0]"></p>
                        </template>
                    </div>
                </div>
            </div>

            {{-- Payment Method --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                    <h2 class="text-sm font-bold text-gray-900">Payment Method</h2>
                </div>
                <div class="p-6">
                    <label class="flex items-center gap-3 p-4 border-2 border-primary bg-primary/5 rounded-lg cursor-pointer">
                        <input type="radio" name="payment_method" value="cod" checked class="hidden peer">
                        <div class="w-6 h-6 rounded-full border-2 border-primary bg-primary flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-check text-white text-xs"></i>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900 text-sm">Cash on Delivery</p>
                            <p class="text-xs text-gray-500">Pay when you receive your order</p>
                        </div>
                        <i class="fas fa-circle-check text-primary text-lg"></i>
                    </label>
                </div>
            </div>

            {{-- Order Notes --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                    <h2 class="text-sm font-bold text-gray-900">Order Notes (Optional)</h2>
                </div>
                <div class="p-6">
                    <textarea name="order_notes" x-model="formData.order_notes" rows="3"
                              placeholder="Any special instructions for your order..."
                              class="w-full px-4 py-3 border border-gray-200 rounded-lg text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition resize-none"></textarea>
                </div>
            </div>

            {{-- Order Notes --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                    <h2 class="text-sm font-bold text-gray-900">Order Notes (Optional)</h2>
                </div>
                <div class="p-6">
                    <textarea name="order_notes" x-model="formData.order_notes" rows="3"
                              placeholder="Any special instructions for your order..."
                              class="w-full px-4 py-3 border border-gray-200 rounded-lg text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition resize-none"></textarea>
                </div>
            </div>

            {{-- Place Order Button mobile --}}
            <button type="button" @click="submitOrder()" :disabled="isSubmitting"
                    class="lg:hidden w-full bg-green-600 hover:bg-green-700 text-white py-4 rounded-lg font-bold text-sm transition shadow-sm disabled:opacity-60">
                <span x-text="isSubmitting ? 'Processing...' : 'Place Order'"></span>
            </button>
        </div>

        {{-- Right: Summary --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden lg:sticky lg:top-24">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                    <h2 class="text-sm font-bold text-gray-900">Order Summary</h2>
                </div>

                <div class="p-6 space-y-5">
                    {{-- Items --}}
                    <div class="space-y-3 max-h-64 overflow-y-auto">
                        @foreach($cart as $item)
                        <div class="flex items-start gap-3 pb-3 border-b border-gray-100 last:border-0 last:pb-0">
                            <div class="w-14 h-14 rounded-lg overflow-hidden bg-gray-100 flex-shrink-0">
                                <img src="{{ $item['image'] ? (str_starts_with($item['image'], 'http') ? $item['image'] : asset('storage/' . $item['image'])) : asset('images/placeholder-product.jpg') }}"
                                     class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-900 truncate">{{ $item['name'] }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $item['quantity'] }} × ৳{{ number_format($item['price'], 0) }}</p>
                            </div>
                            <span class="text-sm font-bold text-gray-900 flex-shrink-0">৳{{ number_format($item['price'] * $item['quantity'], 0) }}</span>
                        </div>
                        @endforeach
                    </div>

                    {{-- Promo Code --}}
                    <div class="pt-3 border-t border-gray-100">
                        <div class="flex gap-2">
                            <input type="text" placeholder="Enter promo code" 
                                   class="flex-1 px-3 py-2.5 border border-gray-200 rounded-lg text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-primary transition">
                            <button type="button" class="px-4 py-2.5 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition">
                                Apply
                            </button>
                        </div>
                    </div>

                    {{-- Totals --}}
                    <div class="space-y-2.5 pt-3 border-t border-gray-100">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Subtotal ({{ count($cart) }} items)</span>
                            <span class="font-semibold text-gray-900">৳{{ number_format($total, 0) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Shipping</span>
                            @if($shipping > 0)
                                <span class="font-semibold text-gray-900">৳{{ number_format($shipping, 0) }}</span>
                            @else
                                <span class="font-bold text-green-600">FREE</span>
                            @endif
                        </div>
                    </div>

                    {{-- Grand Total --}}
                    <div class="flex justify-between items-center py-4 border-t border-b border-gray-100">
                        <span class="text-gray-700 font-medium">Total</span>
                        <span class="text-2xl font-bold text-gray-900">৳{{ number_format($grandTotal, 0) }}</span>
                    </div>

                    {{-- Place Order Button --}}
                    <button type="button" @click="submitOrder()" :disabled="isSubmitting"
                            class="w-full bg-green-600 hover:bg-green-700 text-white py-3.5 rounded-lg font-bold text-sm transition shadow-sm disabled:opacity-60">
                        <span x-text="isSubmitting ? 'Processing...' : 'Place Order'"></span>
                    </button>

                    <div class="flex items-center justify-center gap-2 text-gray-500 text-xs">
                        <i class="fas fa-shield-alt"></i>
                        <span>Secure & encrypted checkout</span>
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
            full_name: '',
            phone: '',
            email: '',
            delivery_zone: 'inside_dhaka',
            full_address: '',
            payment_method: 'cod',
            order_notes: '',
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
