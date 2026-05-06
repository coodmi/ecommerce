@extends('layouts.app')

@section('title', 'Shopping Cart - Ecom Alpha')

@section('content')
<!-- Breadcrumb -->
<section class="bg-slate-50 border-b border-slate-200 py-3 mb-6">
    <div class="container mx-auto px-4">
        <nav class="flex items-center space-x-2 text-xs font-medium text-slate-500">
            <a href="/" class="hover:text-primary transition">Home</a>
            <i class="fas fa-chevron-right text-[9px]"></i>
            <a href="{{ route('shop') }}" class="hover:text-primary transition">Shop</a>
            <i class="fas fa-chevron-right text-[9px]"></i>
            <span class="text-slate-800">Cart</span>
        </nav>
    </div>
</section>

<div class="container mx-auto px-4 pb-12" x-data="cartPage()">
    <div class="flex flex-col lg:flex-row gap-8 items-start" x-show="itemCount > 0" x-cloak>
        <!-- Cart Items -->
        <div class="flex-1 min-w-0 w-full">
            <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
                <h1 class="text-xl font-bold text-slate-900">Your Cart</h1>
                <span class="text-slate-400 font-medium" x-text="itemCount + ' Items'"></span>
            </div>

            <div class="space-y-6">
                @foreach($cart as $id => $details)
                <div class="flex items-center gap-3 p-4 bg-white rounded-xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow cart-item-{{ $id }}">
                    <!-- Image -->
                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-xl overflow-hidden bg-slate-50 flex-shrink-0">
                        <img src="{{ $details['image'] ? (str_starts_with($details['image'], 'http') ? $details['image'] : asset('storage/' . $details['image'])) : asset('images/placeholder-product.jpg') }}" 
                             alt="{{ $details['name'] }}" 
                             class="w-full h-full object-cover">
                    </div>

                    <!-- Info -->
                    <div class="flex-1">
                        <h3 class="font-semibold text-slate-900 text-sm mb-1">{{ $details['name'] }}</h3>
                        <div class="flex flex-wrap gap-2 mb-4">
                            @if(isset($details['color']))
                            <span class="text-[10px] font-bold bg-slate-100 text-slate-600 px-2 py-0.5 rounded uppercase">Color: {{ $details['color'] }}</span>
                            @endif
                            @if(isset($details['size']))
                            <span class="text-[10px] font-bold bg-slate-100 text-slate-600 px-2 py-0.5 rounded uppercase">Size: {{ $details['size'] }}</span>
                            @endif
                            <span class="text-slate-400 text-[10px] font-medium px-2 py-0.5">SKU: {{ $id }}</span>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div class="flex items-center bg-slate-50 rounded-xl p-1">
                                <button type="button" class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-slate-900 hover:bg-white rounded-lg transition" 
                                        @click="updateQuantity('{{ $id }}', -1)">
                                    <i class="fas fa-minus text-[10px]"></i>
                                </button>
                                <span class="w-10 text-center font-bold text-slate-900 text-sm" id="qty-{{ $id }}">{{ $details['quantity'] }}</span>
                                <button type="button" class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-slate-900 hover:bg-white rounded-lg transition" 
                                        @click="updateQuantity('{{ $id }}', 1)">
                                    <i class="fas fa-plus text-[10px]"></i>
                                </button>
                            </div>
                            <span class="text-lg font-black text-slate-900">$<span id="price-{{ $id }}">{{ number_format($details['price'] * $details['quantity'], 2) }}</span></span>
                        </div>
                    </div>

                    <!-- Remove -->
                    <button type="button" class="text-slate-300 hover:text-rose-500 transition-colors p-2" @click="removeItem('{{ $id }}')">
                        <i class="fas fa-trash-can"></i>
                    </button>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Summary -->
        <div class="w-full lg:w-[380px] lg:flex-shrink-0">
            <div class="bg-primary rounded-2xl p-7 text-white lg:sticky lg:top-24">
                <h2 class="text-sm font-bold uppercase tracking-widest mb-5 pb-4 border-b border-white/20">Order Summary</h2>

                <div class="space-y-3 mb-2">
                    <div class="flex justify-between items-center">
                        <span class="text-white/75 text-sm">Subtotal</span>
                        <span class="font-semibold text-sm" id="cart-subtotal">৳{{ number_format($subtotal, 0) }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-white/75 text-sm">{{ $deliveryLabel }}</span>
                        @if($deliveryZones->isNotEmpty())
                            @php
                                $minCharge = $deliveryZones->min('charge');
                                $maxCharge = $deliveryZones->max('charge');
                            @endphp
                            @if($minCharge == $maxCharge)
                                <span class="font-semibold text-sm text-yellow-300" id="cart-shipping">৳{{ number_format($minCharge, 0) }}</span>
                            @else
                                <span class="font-semibold text-sm text-yellow-300" id="cart-shipping">৳{{ number_format($minCharge, 0) }} – ৳{{ number_format($maxCharge, 0) }}</span>
                            @endif
                        @elseif($shipping > 0)
                            <span class="font-semibold text-sm" id="cart-shipping">৳{{ number_format($shipping, 0) }}</span>
                        @else
                            <span class="font-bold text-sm text-yellow-300" id="cart-shipping">FREE</span>
                        @endif
                    </div>

                    @if($deliveryZones->isNotEmpty())
                    <div class="text-xs text-white/60 bg-white/10 rounded-lg px-3 py-2 space-y-1">
                        @foreach($deliveryZones as $zone)
                        <div class="flex justify-between">
                            <span><i class="fas {{ $zone->icon }} mr-1"></i>{{ $zone->name }}</span>
                            <span class="font-semibold">৳{{ number_format($zone->charge, 0) }}</span>
                        </div>
                        @endforeach
                    </div>
                    @elseif($deliveryCharge > 0 && $deliveryFreeThreshold > 0 && $shipping > 0)
                    <div class="text-xs text-white/60 bg-white/10 rounded-lg px-3 py-2">
                        <i class="fas fa-tag mr-1"></i>
                        Add ৳{{ number_format($deliveryFreeThreshold - $subtotal, 0) }} more for free shipping
                    </div>
                    @endif
                </div>

                <div class="flex justify-between items-center py-4 border-t border-b border-white/20 my-4">
                    <span class="text-white/80 text-sm font-medium">Total</span>
                    <span class="cart-total-amount font-bold" id="cart-total">৳{{ number_format($total, 0) }}</span>
                </div>

                <a href="{{ route('checkout.index') }}"
                   class="block w-full bg-white text-primary hover:bg-gray-100 py-3.5 rounded-xl font-bold text-sm text-center transition shadow-sm">
                    Checkout Now
                </a>

                @if($deliveryZones->isNotEmpty())
                <p class="text-center text-white/60 text-xs mt-3">
                    <i class="fas fa-info-circle mr-1"></i>Select your zone at checkout
                </p>
                @endif

                <div class="mt-5 flex items-center justify-center gap-4 text-white/30">
                    <i class="fab fa-cc-visa text-2xl"></i>
                    <i class="fab fa-cc-mastercard text-2xl"></i>
                    <i class="fab fa-cc-apple-pay text-2xl"></i>
                    <i class="fas fa-shield-alt text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Empty Slate -->
    <div class="text-center py-20 bg-white rounded-[3rem] border-2 border-dashed border-slate-100" x-show="itemCount === 0" x-cloak>
        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-shopping-bag text-slate-200 text-3xl"></i>
        </div>
        <h2 class="text-xl font-black text-slate-900 uppercase tracking-widest mb-4">Your cart is empty</h2>
        <a href="{{ route('shop') }}" class="inline-flex items-center gap-2 text-primary font-black uppercase tracking-widest text-xs hover:gap-4 transition-all">
            Start Shopping <i class="fas fa-arrow-right"></i>
        </a>
    </div>
</div>

@push('scripts')
<script>
function cartPage() {
    return {
        total: '{{ number_format($total, 2) }}',
        itemCount: {{ count($cart) }},
        
        updateQuantity(id, mod) {
            const qtyEl = document.getElementById('qty-' + id);
            const priceEl = document.getElementById('price-' + id);
            let currentQty = parseInt(qtyEl.innerText);
            let newQty = currentQty + mod;
            
            if (newQty < 1) return;

            fetch('{{ route('cart.update') }}', {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({id: id, quantity: newQty})
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    qtyEl.innerText = newQty;
                    priceEl.innerText = data.item_total;
                    this.total = data.total;
                    this.itemCount = data.cart_count;
                    document.getElementById('cart-subtotal').textContent = '৳' + data.subtotal;
                    document.getElementById('cart-total').textContent = '৳' + data.total;
                    const shippingEl = document.getElementById('cart-shipping');
                    if (shippingEl) {
                        if (parseFloat(data.shipping) > 0) {
                            shippingEl.textContent = '৳' + data.shipping;
                            shippingEl.className = 'font-semibold text-white';
                        } else {
                            shippingEl.textContent = 'FREE';
                            shippingEl.className = 'font-semibold text-emerald-400';
                        }
                    }
                }
            });
        },

        removeItem(id) {
            window.dispatchEvent(new CustomEvent('confirm-modal', {
                detail: {
                    type: 'danger',
                    icon: 'fa-trash-can',
                    title: 'Remove Item',
                    message: 'Are you sure you want to remove this item from your cart?',
                    confirmText: 'Remove',
                    callback: () => {
                        fetch('{{ route('cart.remove') }}', {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({id: id})
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                document.querySelector('.cart-item-' + id).remove();
                                this.total = data.total;
                                this.itemCount = data.cart_count;
                                
                                window.dispatchEvent(new CustomEvent('toast', {
                                    detail: { type: 'success', message: 'Item removed from cart' }
                                }));
                            }
                        });
                    }
                }
            }));
        }
    }
}
</script>
@endpush
@endsection
