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
                    <div class="space-y-4">
                        {{-- Full Name (Full Width) --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-2">
                                Full Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="full_name" x-model="formData.full_name" required
                                   placeholder="Enter your full name"
                                   class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition">
                            <template x-if="errors.full_name">
                                <p class="text-red-500 text-xs mt-1" x-text="errors.full_name[0]"></p>
                            </template>
                        </div>

                        {{-- Phone and Email (Side by Side) --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-2">
                                    Phone Number <span class="text-red-500">*</span>
                                </label>
                                <input type="tel" name="phone" x-model="formData.phone" required
                                       placeholder="e.g. 01712345678"
                                       class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition">
                                <template x-if="errors.phone">
                                    <p class="text-red-500 text-xs mt-1" x-text="errors.phone[0]"></p>
                                </template>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-2">
                                    Email (Optional)
                                </label>
                                <input type="email" name="email" x-model="formData.email"
                                       placeholder="your.email@example.com"
                                       class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition">
                                <template x-if="errors.email">
                                    <p class="text-red-500 text-xs mt-1" x-text="errors.email[0]"></p>
                                </template>
                            </div>
                        </div>
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
                            @foreach($deliveryZones as $zone)
                            <label class="relative cursor-pointer"
                                   @click="formData.delivery_zone = '{{ $zone->id }}'; updateShipping()">
                                <input type="radio" name="delivery_zone" value="{{ $zone->id }}"
                                       x-model="formData.delivery_zone" class="hidden" required>
                                <div :class="formData.delivery_zone == '{{ $zone->id }}'
                                        ? 'border-primary bg-primary/5'
                                        : 'border-gray-200 bg-white hover:border-gray-300'"
                                     class="p-4 border-2 rounded-xl transition-all duration-150">
                                    <div class="flex items-center gap-3">
                                        {{-- Radio circle --}}
                                        <div :class="formData.delivery_zone == '{{ $zone->id }}'
                                                ? 'bg-primary border-primary'
                                                : 'border-gray-300'"
                                             class="w-6 h-6 rounded-full border-2 flex items-center justify-center flex-shrink-0 transition-all">
                                            <i class="fas fa-check text-white text-xs"
                                               x-show="formData.delivery_zone == '{{ $zone->id }}'"></i>
                                        </div>
                                        {{-- Icon --}}
                                        <i class="fas {{ $zone->icon }} text-lg"
                                           :class="formData.delivery_zone == '{{ $zone->id }}' ? 'text-primary' : 'text-gray-400'"></i>
                                        {{-- Text --}}
                                        <div class="flex-1">
                                            <p class="font-bold text-gray-900 text-sm">{{ $zone->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $zone->delivery_time }}</p>
                                        </div>
                                        {{-- Price --}}
                                        <span class="font-bold text-sm"
                                              :class="formData.delivery_zone == '{{ $zone->id }}' ? 'text-primary' : 'text-gray-700'">
                                            ৳{{ number_format($zone->charge, 0) }}
                                        </span>
                                    </div>
                                </div>
                            </label>
                            @endforeach
                        </div>
                        <template x-if="errors.delivery_zone">
                            <p class="text-red-500 text-xs mt-2" x-text="errors.delivery_zone[0]"></p>
                        </template>
                    </div>

                    {{-- Full Address --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-2">Full Address <span class="text-red-500">*</span></label>
                        <textarea name="full_address" x-model="formData.full_address" required rows="4"
                                  placeholder="Your Full Address"
                                  class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition resize-none"></textarea>
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
                              class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition resize-none"></textarea>
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
                              class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition resize-none"></textarea>
                </div>
            </div>

            {{-- Place Order Button mobile --}}
            <button type="button" @click="submitOrder()" :disabled="isSubmitting"
                    class="lg:hidden w-full bg-primary hover:bg-primary/90 text-white py-4 rounded-lg font-bold text-sm transition shadow-sm disabled:opacity-60">
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
                                   class="flex-1 px-3 py-2.5 border-2 border-gray-400 rounded-lg text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-primary transition">
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
                            <span class="font-semibold text-gray-900" x-text="'৳' + formatNumber(shippingCost)"></span>
                        </div>
                    </div>

                    {{-- Grand Total --}}
                    <div class="flex justify-between items-center py-4 border-t border-b border-gray-100">
                        <span class="text-gray-700 font-medium">Total</span>
                        <span class="text-2xl font-bold text-gray-900" x-text="'৳' + formatNumber(grandTotal)"></span>
                    </div>

                    {{-- Place Order Button --}}
                    <button type="button" @click="submitOrder()" :disabled="isSubmitting"
                            class="w-full bg-primary hover:bg-primary/90 text-white py-3.5 rounded-lg font-bold text-sm transition shadow-sm disabled:opacity-60">
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
        subtotal: {{ (float) $total }},
        shippingCost: 0,
        deliveryZones: {!! json_encode($deliveryZones->mapWithKeys(fn($z) => [$z->id => (float) $z->charge])->toArray()) !!},
        formData: {
            full_name: '',
            phone: '',
            email: '',
            delivery_zone: '',
            full_address: '',
            payment_method: 'cod',
            order_notes: '',
            @foreach($fields as $field)
                '{{ $field->name }}': '',
            @endforeach
        },
        errors: {},
        isSubmitting: false,

        get grandTotal() {
            return parseFloat(this.subtotal) + parseFloat(this.shippingCost);
        },

        formatNumber(num) {
            return Math.round(num).toLocaleString('en-BD');
        },

        updateShipping() {
            const zoneId = parseInt(this.formData.delivery_zone);
            this.shippingCost = parseFloat(this.deliveryZones[zoneId]) || 0;
        },

        submitOrder() {
            // Client-side check: must select a delivery zone
            if (!this.formData.delivery_zone) {
                window.dispatchEvent(new CustomEvent('toast', {
                    detail: { type: 'error', title: 'Select Delivery Zone', message: 'Please select a delivery zone to continue.' }
                }));
                // Scroll to delivery zone section
                document.querySelector('[name="delivery_zone"]')?.closest('.space-y-5')?.scrollIntoView({ behavior: 'smooth', block: 'center' });
                return;
            }

            this.isSubmitting = true;
            this.errors = {};

            fetch('{{ route('checkout.store') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    ...this.formData,
                    shipping_cost: this.shippingCost,
                    total_amount: this.grandTotal
                })
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
                    // Build a readable error list
                    const msgs = Object.values(data.errors).flat().join(' ');
                    window.dispatchEvent(new CustomEvent('toast', {
                        detail: { type: 'error', title: 'Please fix the errors', message: msgs }
                    }));
                    // Scroll to first error
                    setTimeout(() => {
                        const firstErr = document.querySelector('[class*="text-red-500"]');
                        if (firstErr) firstErr.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }, 100);
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
