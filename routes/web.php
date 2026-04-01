<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    $popularCategories = \App\Models\Category::where('is_active', true)
        ->withCount('products')
        ->orderByDesc('is_popular')
        ->orderBy('name')
        ->get();

    // Get featured products (first 8 products with images)
    $dealProducts = \App\Models\Product::where('is_active', true)
        ->with(['category', 'images', 'colors', 'sizes', 'primaryImage', 'brand'])
        ->take(8)
        ->get();

    // Get active brands with product count
    $brands = \App\Models\Brand::where('is_active', true)
        ->withCount('products')
        ->latest()
        ->get();

    // Get Home page sections for dynamic content
    $page = \App\Models\Page::where('slug', 'home')->with('sections')->first();
    $sections = $page ? $page->sections->pluck('content', 'key') : collect();

    return view('pages.landing', compact('popularCategories', 'dealProducts', 'sections', 'brands'));
});

Route::get('/shop', [App\Http\Controllers\ProductController::class, 'index'])->name('shop');
Route::get('/product/{slug}', [App\Http\Controllers\ProductController::class, 'show'])->name('product.details');
Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index')->middleware('auth');
Route::post('/checkout', [App\Http\Controllers\CheckoutController::class, 'store'])->name('checkout.store')->middleware('auth');

Route::get('/categories', [App\Http\Controllers\ProductController::class, 'categories'])->name('categories');

Route::get('/deals', [App\Http\Controllers\DealsController::class, 'index'])->name('deals');

Route::get('/returns', function () {
    $returnStatuses = ['returned', 'refunded', 'return_requested'];
    $returnOrders = \App\Models\Order::where('user_id', auth()->id())
        ->whereIn('status', $returnStatuses)
        ->with(['items.product.primaryImage'])
        ->latest()
        ->paginate(10);

    $totalReturns    = \App\Models\Order::where('user_id', auth()->id())->whereIn('status', $returnStatuses)->count();
    $pendingReturns  = \App\Models\Order::where('user_id', auth()->id())->where('status', 'return_requested')->count();
    $completedReturns = \App\Models\Order::where('user_id', auth()->id())->whereIn('status', ['returned', 'refunded'])->count();

    return view('pages.returns', compact('returnOrders', 'totalReturns', 'pendingReturns', 'completedReturns'));
})->name('returns');

// Policy Pages
Route::get('/privacy-policy', function () {
    $page = \App\Models\Page::where('slug', 'privacy-policy')->with('sections')->first();
    $sections = $page ? $page->sections->pluck('content', 'key') : collect();
    return view('pages.policy', ['title' => 'Privacy Policy', 'slug' => 'privacy-policy', 'sections' => $sections]);
})->name('privacy-policy');

Route::get('/terms-conditions', function () {
    $page = \App\Models\Page::where('slug', 'terms-conditions')->with('sections')->first();
    $sections = $page ? $page->sections->pluck('content', 'key') : collect();
    return view('pages.policy', ['title' => 'Terms & Conditions', 'slug' => 'terms-conditions', 'sections' => $sections]);
})->name('terms-conditions');

Route::get('/refund-policy', function () {
    $page = \App\Models\Page::where('slug', 'refund-policy')->with('sections')->first();
    $sections = $page ? $page->sections->pluck('content', 'key') : collect();
    return view('pages.policy', ['title' => 'Refund Policy', 'slug' => 'refund-policy', 'sections' => $sections]);
})->name('refund-policy');

Route::get('/about', function () {
    $page = \App\Models\Page::where('slug', 'about-us')->with('sections')->first();
    return view('pages.about', compact('page'));
});

Route::post('/contact', [App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');

Route::get('/contact', function () {
    $page = \App\Models\Page::where('slug', 'contact-us')->with('sections')->first();
    return view('pages.contact', compact('page'));
});

// Authentication Routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials, $request->filled('remember'))) {
        $request->session()->regenerate();
        return redirect()->intended('/dashboard');
    }

    return back()->with('error', 'Invalid credentials. Please try again.');
})->name('login.post');

Route::get('/register', [App\Http\Controllers\RegisterController::class, 'show'])->name('register');
Route::post('/register', [App\Http\Controllers\RegisterController::class, 'register'])->name('register.post');

Route::post('/logout', function (Illuminate\Http\Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// Dashboard Routes (Protected)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');

    // User Orders
    Route::get('/my-orders', [App\Http\Controllers\User\OrderController::class, 'index'])->name('user.orders');
    Route::get('/orders/{order}/invoice', [App\Http\Controllers\CheckoutController::class, 'invoice'])->name('order.invoice');
    
    // User Reviews
    Route::get('/my-reviews', [App\Http\Controllers\ReviewController::class, 'index'])->name('user.reviews');

    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile');
    Route::post('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

    // Seller Request Routes
    Route::post('/seller-request', [App\Http\Controllers\SellerRequestController::class, 'store'])->name('seller.request');

    // Wishlist Routes
    Route::get('/wishlist', [App\Http\Controllers\WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle/{product}', [App\Http\Controllers\WishlistController::class, 'toggle'])->name('wishlist.toggle');

    // Admin Only Routes
    Route::middleware(\App\Http\Middleware\RoleMiddleware::class.':admin')->prefix('admin')->name('admin.')->group(function () {
        // Seller Requests
        Route::get('/seller-requests', [App\Http\Controllers\SellerRequestController::class, 'index'])->name('seller-requests');
        Route::get('/seller-requests/{id}', [App\Http\Controllers\SellerRequestController::class, 'show'])->name('seller-requests.show');
        Route::post('/seller-requests/{id}/approve', [App\Http\Controllers\SellerRequestController::class, 'approve'])->name('seller-requests.approve');
        Route::post('/seller-requests/{id}/reject', [App\Http\Controllers\SellerRequestController::class, 'reject'])->name('seller-requests.reject');
        Route::delete('/seller-requests/{id}', [App\Http\Controllers\SellerRequestController::class, 'destroy'])->name('seller-requests.delete');

        // Users Management
        Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
        Route::put('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');

        // Categories Management
        Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
        Route::post('/categories/bulk-delete', [App\Http\Controllers\Admin\CategoryController::class, 'bulkDelete'])->name('categories.bulk-delete');

        // Brands Management
        Route::resource('brands', App\Http\Controllers\Admin\BrandController::class);

        // Products Management
        Route::resource('products', App\Http\Controllers\Admin\ProductController::class);

        // Checkout Fields Management
        Route::resource('checkout-fields', App\Http\Controllers\Admin\CheckoutFieldController::class);

        // Orders Management
        Route::get('/orders', [App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
        Route::delete('/orders/{order}', [App\Http\Controllers\Admin\OrderController::class, 'destroy'])->name('orders.destroy');
        Route::put('/orders/{order}/status', [App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.update-status');
        Route::put('/orders/{order}/notes', [App\Http\Controllers\Admin\OrderController::class, 'updateNotes'])->name('orders.update-notes');

        // Pages
        Route::resource('pages', App\Http\Controllers\Admin\PageController::class);

        // Site Settings
        Route::get('/settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');

        // Contact Messages
        Route::get('/contact-messages', [App\Http\Controllers\Admin\ContactMessageController::class, 'index'])->name('contact-messages.index');
        Route::get('/contact-messages/{contactMessage}', [App\Http\Controllers\Admin\ContactMessageController::class, 'show'])->name('contact-messages.show');
        Route::delete('/contact-messages/{contactMessage}', [App\Http\Controllers\Admin\ContactMessageController::class, 'destroy'])->name('contact-messages.destroy');

        // Review Management
        Route::get('/reviews', [App\Http\Controllers\Admin\ReviewController::class, 'index'])->name('reviews.index');
        Route::post('/reviews/{review}/approve', [App\Http\Controllers\Admin\ReviewController::class, 'approve'])->name('reviews.approve');
        Route::post('/reviews/{review}/reject', [App\Http\Controllers\Admin\ReviewController::class, 'reject'])->name('reviews.reject');
        Route::delete('/reviews/{review}', [App\Http\Controllers\Admin\ReviewController::class, 'destroy'])->name('reviews.destroy');
    });
});

Route::post('/product/{product}/review', [App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');

// API Routes for AJAX requests
Route::get('/api/search', function (Illuminate\Http\Request $request) {
    $query = $request->get('q', '');
    $limit = $request->get('limit', 8);
    
    if (strlen($query) < 2) {
        return response()->json(['products' => []]);
    }
    
    $products = \App\Models\Product::where('is_active', true)
        ->where(function($q) use ($query) {
            $q->where('name', 'LIKE', "%{$query}%")
              ->orWhere('description', 'LIKE', "%{$query}%");
        })
        ->with(['category', 'primaryImage'])
        ->take($limit)
        ->get()
        ->map(function($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => number_format($product->base_price, 2),
                'category' => $product->category->name ?? 'Uncategorized',
                'image' => $product->primaryImage ? $product->primaryImage->url : asset('images/placeholder.jpg'),
                'rating' => $product->rating ?? 4
            ];
        });
    
    return response()->json(['products' => $products]);
});
