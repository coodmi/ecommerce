@extends('layouts.app')

@section('title', 'Shopping Cart - Ecom Alpha')

@section('content')
<!-- Breadcrumb -->
<section class="bg-slate-50 border-b border-slate-200 py-6 mb-12">
    <div class="container mx-auto px-4">
        <nav class="flex items-center space-x-2 text-sm font-medium">
            <a href="/" class="text-slate-500 hover:text-primary transition">Home</a>
            <i class="fas fa-chevron-right text-[10px] text-slate-300"></i>
            <a href="{{ route('shop') }}" class="text-slate-500 hover:text-primary transition">Shop</a>
            <i class="fas fa-chevron-right text-[10px] text-slate-300"></i>
            <span class="text-slate-900">Your Cart</span>
        </nav>
    </div>
</section>

<div class="container mx-auto px-4 pb-20" x-data="cartPage()">
    <div class="flex flex-col lg:flex-row gap-12" x-show="itemCount > 0" x-cloak>
        <!-- Cart Items -->
        <div class="lg:w-2/3">
            <div class="flex items-center justify-between mb-8 pb-4 border-b border-slate-100">
                <h1 class="text-3xl font-black text-slate-900 uppercase tracking-tight">Your Cart</h1>
                <span class="text-slate-400 font-medium" x-text="itemCount + ' Items'"></span>
            </div>

            <div class="space-y-6">
                @foreach($cart as $id => $details)
                <div class="flex items-center gap-6 p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-md transition-shadow cart-item-{{ $id }}">
                    <!-- Image -->
                    <div class="w-32 h-32 rounded-2xl overflow-hidden bg-slate-50 flex-shrink-0">
                        <img src="{{ $details['image'] ? (str_starts_with($details['image'], 'http') ? $details['image'] : asset('storage/' . $details['image'])) : asset('images/placeholder-product.jpg') }}" 
                             alt="{{ $details['name'] }}" 
                             class="w-full h-full object-cover">
                    </div>

                    <!-- Info -->
                    <div class="flex-1">
                        <h3 class="font-black text-slate-900 uppercase tracking-widest text-sm mb-1">{{ $details['name'] }}</h3>
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
        <div class="lg:w-1/3">
            <div class="bg-slate-900 rounded-[2.5rem] p-10 text-white sticky top-24">
                <h2 class="text-2xl font-black uppercase tracking-tight mb-8">Order Summary</h2>
                
                <div class="space-y-4 mb-8">
                    <div class="flex justify-between text-slate-400">
                        <span class="font-medium">Subtotal</span>
                        <span class="font-bold whitespace-nowrap">$<span x-text="total"></span></span>
                    </div>
                    <div class="flex justify-between text-slate-400">
                        <span class="font-medium">Shipping</span>
                        <span class="font-bold text-emerald-400">FREE</span>
                    </div>
                    <div class="flex justify-between text-slate-400 border-t border-slate-800 pt-4 mt-4">
                        <span class="font-medium">Estimated Tax</span>
                        <span class="font-bold whitespace-nowrap">$0.00</span>
                    </div>
                </div>

                <div class="flex justify-between items-end mb-10 pb-10 border-b border-white/10">
                    <span class="text-slate-400 font-medium">Total Price</span>
                    <span class="text-4xl font-black">$<span x-text="total"></span></span>
                </div>

                <a href="{{ route('checkout.index') }}" class="w-full bg-primary hover:bg-primary/90 text-white py-5 rounded-2xl font-black uppercase tracking-[0.2em] transition-all duration-300 transform hover:scale-[1.02] active:scale-[0.98] shadow-xl shadow-primary/20 flex items-center justify-center">
                    Checkout Now
                </a>

                <div class="mt-8 flex items-center justify-center gap-4 text-slate-500">
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
