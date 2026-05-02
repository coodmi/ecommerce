@extends('layouts.app')

@section('title', 'Shop - Ecom Alpha')

@section('content')

<!-- Hero Banner -->
<section class="bg-linear-to-r from-primary to-primary/80 text-white py-10">
    <div class="container mx-auto px-4">
        <nav class="flex items-center space-x-2 text-sm mb-3 opacity-80">
            <a href="/" class="hover:opacity-100 transition"><i class="fas fa-home"></i> Home</a>
            <i class="fas fa-chevron-right text-xs"></i>
            <span>Shop</span>
        </nav>
        <h1 class="text-2xl md:text-3xl font-bold font-display">Our Shop</h1>
        <p class="text-white/80 mt-1 text-sm">Discover amazing products at unbeatable prices</p>
    </div>
</section>

<!-- Shop Section -->
<section class="py-6 md:py-12 bg-gray-50" x-data="shopFilter()">
    <div class="container mx-auto px-4">

        {{-- ── MOBILE TOOLBAR ── --}}
        <div class="flex items-center gap-3 mb-4 lg:hidden">
            {{-- Filter toggle --}}
            <button @click="drawerOpen = true"
                    class="flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm font-semibold text-gray-700 shadow-sm flex-1 justify-center">
                <i class="fas fa-sliders-h text-primary"></i> Filters
                <template x-if="activeFilterCount > 0">
                    <span class="ml-1 w-5 h-5 bg-primary text-white rounded-full text-xs flex items-center justify-center font-bold" x-text="activeFilterCount"></span>
                </template>
            </button>
            {{-- Sort --}}
            <select x-model="sort" @change="updateFilters()"
                    class="flex-1 px-3 py-2.5 bg-white border border-gray-200 rounded-xl text-sm font-semibold text-gray-700 shadow-sm focus:outline-none focus:border-primary">
                <option value="latest">Latest</option>
                <option value="price_low">Price ↑</option>
                <option value="price_high">Price ↓</option>
            </select>
        </div>

        {{-- ── MOBILE FILTER DRAWER ── --}}
        <div x-show="drawerOpen" x-cloak class="fixed inset-0 z-50 lg:hidden" style="display:none;">
            {{-- Backdrop --}}
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="drawerOpen = false"></div>

            {{-- Drawer panel --}}
            <div class="absolute bottom-0 left-0 right-0 bg-white rounded-t-3xl max-h-[88vh] flex flex-col"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="translate-y-full"
                 x-transition:enter-end="translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="translate-y-0"
                 x-transition:leave-end="translate-y-full">

                {{-- Drawer header --}}
                <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 flex-shrink-0">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-sliders-h text-primary"></i>
                        <span class="font-bold text-gray-900">Filters</span>
                        <template x-if="activeFilterCount > 0">
                            <span class="w-5 h-5 bg-primary text-white rounded-full text-xs flex items-center justify-center font-bold" x-text="activeFilterCount"></span>
                        </template>
                    </div>
                    <button @click="drawerOpen = false" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 text-gray-500 hover:bg-gray-200">
                        <i class="fas fa-times text-sm"></i>
                    </button>
                </div>

                {{-- Scrollable filter content --}}
                <div class="overflow-y-auto flex-1 px-5 py-4 space-y-6">

                    {{-- Search --}}
                    <div>
                        <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Search</h3>
                        <div class="relative">
                            <input type="text" x-model="search" @input.debounce.500ms="updateFilters()"
                                   placeholder="Search products..."
                                   class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary">
                            <i class="fas fa-search absolute left-3 top-3.5 text-gray-400 text-sm"></i>
                        </div>
                    </div>

                    {{-- Categories --}}
                    <div>
                        <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Categories</h3>
                        <div class="space-y-2">
                            <label class="flex items-center justify-between p-3 rounded-xl border border-gray-100 cursor-pointer hover:border-primary/30 transition"
                                   :class="allCategoriesSelected ? 'border-primary bg-primary/5' : ''">
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" x-model="allCategoriesSelected" @change="toggleAllCategories()"
                                           class="w-4 h-4 text-primary rounded focus:ring-primary">
                                    <span class="text-sm font-semibold text-gray-700">All Categories</span>
                                </div>
                            </label>
                            @foreach($categories as $category)
                            <label class="flex items-center justify-between p-3 rounded-xl border border-gray-100 cursor-pointer hover:border-primary/30 transition"
                                   :class="selectedCategories.includes('{{ $category->id }}') ? 'border-primary bg-primary/5' : ''">
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" value="{{ $category->id }}" x-model="selectedCategories" @change="updateFilters()"
                                           class="w-4 h-4 text-primary rounded focus:ring-primary">
                                    <span class="text-sm text-gray-700">{{ $category->name }}</span>
                                </div>
                                <span class="text-xs text-gray-400 font-bold bg-gray-100 px-2 py-0.5 rounded-full">{{ $category->products_count ?? $category->products->count() }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Price Range --}}
                    <div>
                        <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Price Range</h3>
                        <input type="range" min="0" max="2000" x-model="maxPrice" @input.debounce.500ms="updateFilters()"
                               class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-primary mb-3">
                        <div class="flex items-center gap-3">
                            <input type="number" x-model="minPrice" @input.debounce.500ms="updateFilters()" placeholder="Min"
                                   class="flex-1 px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary text-center">
                            <span class="text-gray-400 text-sm">to</span>
                            <input type="number" x-model="maxPrice" @input.debounce.500ms="updateFilters()" placeholder="Max"
                                   class="flex-1 px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary text-center">
                        </div>
                    </div>

                    {{-- Brands --}}
                    @if($allBrands->count())
                    <div>
                        <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Brands</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($allBrands as $brand)
                            <label class="cursor-pointer">
                                <input type="checkbox" value="{{ $brand->id }}" x-model="selectedBrands" @change="updateFilters()" class="hidden peer">
                                <span class="px-3 py-2 border border-gray-200 rounded-xl text-xs font-semibold text-gray-600 peer-checked:bg-primary peer-checked:text-white peer-checked:border-primary transition block">
                                    {{ $brand->name }}
                                </span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Rating --}}
                    <div>
                        <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Rating</h3>
                        <div class="space-y-2">
                            @foreach([5, 4, 3] as $rating)
                            <label class="flex items-center gap-3 p-3 rounded-xl border border-gray-100 cursor-pointer hover:border-primary/30 transition"
                                   :class="selectedRatings.includes('{{ $rating }}') ? 'border-primary bg-primary/5' : ''">
                                <input type="checkbox" value="{{ $rating }}" x-model="selectedRatings" @change="updateFilters()"
                                       class="w-4 h-4 text-primary rounded focus:ring-primary">
                                <div class="flex text-yellow-400 text-xs">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="{{ $i <= $rating ? 'fas' : 'far' }} fa-star"></i>
                                    @endfor
                                </div>
                                <span class="text-xs text-gray-500">& Up</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Colors --}}
                    @if($allColors->count())
                    <div>
                        <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Colors</h3>
                        <div class="flex flex-wrap gap-3">
                            @foreach($allColors as $color)
                            <button type="button" @click="toggleColor('{{ $color->color_name }}')"
                                    class="w-9 h-9 rounded-full border-2 transition-all hover:scale-110 flex items-center justify-center"
                                    :class="selectedColors.includes('{{ $color->color_name }}') ? 'border-primary ring-2 ring-primary/30' : 'border-gray-200'"
                                    style="background-color: {{ $color->color_code }}" title="{{ $color->color_name }}">
                                <i x-show="selectedColors.includes('{{ $color->color_name }}')" class="fas fa-check text-[10px]"
                                   :class="'{{ $color->color_code }}' === '#FFFFFF' ? 'text-black' : 'text-white'"></i>
                            </button>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Sizes --}}
                    @if($allSizes->count())
                    <div>
                        <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Sizes</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($allSizes as $size)
                            <button type="button" @click="toggleSize('{{ $size->size_name }}')"
                                    class="px-4 py-2 border rounded-xl text-xs font-bold transition-all"
                                    :class="selectedSizes.includes('{{ $size->size_name }}') ? 'bg-primary text-white border-primary' : 'bg-white text-gray-700 border-gray-200 hover:border-primary/40'">
                                {{ $size->size_name }}
                            </button>
                            @endforeach
                        </div>
                    </div>
                    @endif

                </div>

                {{-- Drawer footer --}}
                <div class="flex gap-3 px-5 py-4 border-t border-gray-100 flex-shrink-0">
                    <button @click="resetFilters(); drawerOpen = false"
                            class="flex-1 py-3 border border-gray-200 rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">
                        Reset
                    </button>
                    <button @click="drawerOpen = false"
                            class="flex-1 py-3 bg-primary text-white rounded-xl text-sm font-bold hover:bg-primary/90 transition">
                        Show Results
                    </button>
                </div>
            </div>
        </div>

        {{-- ── DESKTOP LAYOUT ── --}}
        <div class="flex flex-col lg:flex-row gap-8">

            <!-- Desktop Sidebar -->
            <aside class="hidden lg:block lg:w-1/4">
                <div class="bg-white rounded-2xl shadow-md p-6 sticky top-24">

                    <div class="mb-8">
                        <h3 class="font-semibold text-sm text-gray-800 mb-3 flex items-center">
                            <i class="fas fa-search text-primary mr-2"></i> Search Products
                        </h3>
                        <div class="relative">
                            <input type="text" x-model="search" @input.debounce.500ms="updateFilters()" placeholder="Search..."
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary transition">
                            <button class="absolute right-3 top-3 text-gray-400 hover:text-primary transition">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mb-8 pb-8 border-b border-gray-200">
                        <h3 class="font-semibold text-sm text-gray-800 mb-3 flex items-center">
                            <i class="fas fa-th-large text-primary mr-2"></i> Categories
                        </h3>
                        <ul class="space-y-3">
                            <li>
                                <label class="flex items-center justify-between cursor-pointer group">
                                    <div class="flex items-center">
                                        <input type="checkbox" value="" x-model="allCategoriesSelected" @change="toggleAllCategories()"
                                               class="w-4 h-4 text-primary rounded focus:ring-primary">
                                        <span class="ml-3 text-sm font-semibold text-gray-700 group-hover:text-primary transition">All Categories</span>
                                    </div>
                                </label>
                            </li>
                            @foreach($categories as $category)
                            <li>
                                <label class="flex items-center justify-between cursor-pointer group">
                                    <div class="flex items-center">
                                        <input type="checkbox" value="{{ $category->id }}" x-model="selectedCategories" @change="updateFilters()"
                                               class="w-4 h-4 text-primary rounded focus:ring-primary">
                                        <span class="ml-3 text-sm text-gray-700 group-hover:text-primary transition">{{ $category->name }}</span>
                                    </div>
                                    <span class="text-xs text-gray-400 font-bold bg-gray-50 px-2 py-1 rounded-full">({{ $category->products_count ?? $category->products->count() }})</span>
                                </label>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="mb-8 pb-8 border-b border-gray-200">
                        <h3 class="font-semibold text-sm text-gray-800 mb-3 flex items-center">
                            <i class="fas fa-dollar-sign text-primary mr-2"></i> Price Range
                        </h3>
                        <div class="space-y-4">
                            <input type="range" min="0" max="2000" x-model="maxPrice" @input.debounce.500ms="updateFilters()"
                                   class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-primary">
                            <div class="flex items-center justify-between">
                                <input type="number" x-model="minPrice" @input.debounce.500ms="updateFilters()" placeholder="Min"
                                       class="w-24 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary text-sm">
                                <span class="text-gray-500">to</span>
                                <input type="number" x-model="maxPrice" @input.debounce.500ms="updateFilters()" placeholder="Max"
                                       class="w-24 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary text-sm">
                            </div>
                        </div>
                    </div>

                    <div class="mb-8 pb-8 border-b border-gray-200">
                        <h3 class="font-semibold text-sm text-gray-800 mb-3 flex items-center">
                            <i class="fas fa-tag text-primary mr-2"></i> Brands
                        </h3>
                        <ul class="space-y-3">
                            @foreach($allBrands as $brand)
                            <li>
                                <label class="flex items-center justify-between cursor-pointer group">
                                    <div class="flex items-center">
                                        <input type="checkbox" value="{{ $brand->id }}" x-model="selectedBrands" @change="updateFilters()"
                                               class="w-4 h-4 text-primary rounded focus:ring-primary">
                                        <span class="ml-3 text-gray-700 group-hover:text-primary transition">{{ $brand->name }}</span>
                                    </div>
                                    @if($brand->logo)
                                        <img src="{{ $brand->logo_url }}" class="w-6 h-6 object-contain opacity-50 group-hover:opacity-100 transition-opacity">
                                    @endif
                                </label>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="mb-8 pb-8 border-b border-gray-200">
                        <h3 class="font-semibold text-sm text-gray-800 mb-3 flex items-center">
                            <i class="fas fa-star text-primary mr-2"></i> Rating
                        </h3>
                        <ul class="space-y-3">
                            @foreach([5, 4, 3] as $rating)
                            <li>
                                <label class="flex items-center cursor-pointer group">
                                    <input type="checkbox" value="{{ $rating }}" x-model="selectedRatings" @change="updateFilters()"
                                           class="w-4 h-4 text-primary rounded focus:ring-primary">
                                    <div class="ml-3 flex text-yellow-400">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="{{ $i <= $rating ? 'fas' : 'far' }} fa-star"></i>
                                        @endfor
                                    </div>
                                    <span class="ml-2 text-sm text-gray-500">& Up</span>
                                </label>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="mb-8 pb-8 border-b border-gray-200">
                        <h3 class="font-semibold text-sm text-gray-800 mb-3 flex items-center">
                            <i class="fas fa-palette text-primary mr-2"></i> Colors
                        </h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($allColors as $color)
                            <button type="button" @click="toggleColor('{{ $color->color_name }}')"
                                    class="w-8 h-8 rounded-full border-2 transition-all duration-300 hover:scale-110 flex items-center justify-center relative"
                                    :class="selectedColors.includes('{{ $color->color_name }}') ? 'border-primary ring-2 ring-primary/20' : 'border-gray-200'"
                                    style="background-color: {{ $color->color_code }}" title="{{ $color->color_name }}">
                                <i x-show="selectedColors.includes('{{ $color->color_name }}')" class="fas fa-check text-[10px]"
                                   :class="'{{ $color->color_code }}' === '#FFFFFF' ? 'text-black' : 'text-white'"></i>
                            </button>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-8">
                        <h3 class="font-semibold text-sm text-gray-800 mb-3 flex items-center">
                            <i class="fas fa-ruler-combined text-primary mr-2"></i> Sizes
                        </h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($allSizes as $size)
                            <button type="button" @click="toggleSize('{{ $size->size_name }}')"
                                    class="px-3 py-2 border rounded-lg text-xs font-bold transition-all duration-300"
                                    :class="selectedSizes.includes('{{ $size->size_name }}') ? 'bg-primary text-white border-primary shadow-md' : 'bg-white text-gray-700 border-gray-200 hover:border-primary/30'">
                                {{ $size->size_name }}
                            </button>
                            @endforeach
                        </div>
                    </div>

                    <button @click="resetFilters()" class="w-full bg-linear-to-r from-primary to-primary/80 text-white py-3 rounded-lg font-semibold hover:shadow-lg transition duration-300">
                        <i class="fas fa-redo mr-2"></i> Reset Filters
                    </button>
                </div>
            </aside>

            <!-- Products Area -->
            <main class="lg:w-3/4 w-full">

                <!-- Desktop Toolbar -->
                <div class="hidden lg:flex bg-white rounded-2xl shadow-md p-4 mb-6 items-center justify-between">
                    <p class="text-gray-600 text-sm">
                        Showing <span class="font-bold text-slate-900" x-text="showingCount">{{ $products->count() }}</span> results
                    </p>
                    <select x-model="sort" @change="updateFilters()"
                            class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary text-sm font-semibold">
                        <option value="latest">Latest First</option>
                        <option value="price_low">Price: Low to High</option>
                        <option value="price_high">Price: High to Low</option>
                    </select>
                </div>

                <!-- Mobile result count -->
                <p class="lg:hidden text-xs text-gray-500 mb-3">
                    Showing <span class="font-bold text-gray-800" x-text="showingCount">{{ $products->count() }}</span> results
                </p>

                <!-- Products Grid -->
                <div id="product-container" x-ref="productContainer">
                    @include('pages.partials.product-list')
                </div>

                <!-- Pagination -->
                <div class="mt-8 pagination-container" x-ref="paginationContainer">
                    {{ $products->links() }}
                </div>
            </main>
        </div>
    </div>
</section>

@push('scripts')
<script>
function shopFilter() {
    return {
        selectedCategories: [],
        selectedBrands: [],
        selectedRatings: [],
        selectedColors: [],
        selectedSizes: [],
        minPrice: 0,
        maxPrice: 2000,
        search: '',
        sort: 'latest',
        allCategoriesSelected: true,
        showingCount: {{ $products->count() }},
        drawerOpen: false,

        get activeFilterCount() {
            return this.selectedCategories.length
                + this.selectedBrands.length
                + this.selectedRatings.length
                + this.selectedColors.length
                + this.selectedSizes.length
                + (this.search ? 1 : 0)
                + (this.minPrice > 0 || this.maxPrice < 2000 ? 1 : 0);
        },

        init() {
            this.$watch('selectedCategories', (value) => {
                this.allCategoriesSelected = value.length === 0;
            });
            document.addEventListener('click', (e) => {
                const link = e.target.closest('.pagination-container a');
                if (link) {
                    e.preventDefault();
                    this.updateFilters(link.href);
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            });
        },

        toggleAllCategories() {
            if (this.allCategoriesSelected) this.selectedCategories = [];
            this.updateFilters();
        },

        toggleColor(color) {
            this.selectedColors.includes(color)
                ? this.selectedColors = this.selectedColors.filter(c => c !== color)
                : this.selectedColors.push(color);
            this.updateFilters();
        },

        toggleSize(size) {
            this.selectedSizes.includes(size)
                ? this.selectedSizes = this.selectedSizes.filter(s => s !== size)
                : this.selectedSizes.push(size);
            this.updateFilters();
        },

        resetFilters() {
            this.selectedCategories = [];
            this.selectedBrands = [];
            this.selectedRatings = [];
            this.selectedColors = [];
            this.selectedSizes = [];
            this.minPrice = 0;
            this.maxPrice = 2000;
            this.search = '';
            this.sort = 'latest';
            this.allCategoriesSelected = true;
            this.updateFilters();
        },

        updateFilters(url = null) {
            const params = new URLSearchParams();
            this.selectedCategories.forEach(c => params.append('categories[]', c));
            this.selectedBrands.forEach(b => params.append('brands[]', b));
            this.selectedRatings.forEach(r => params.append('ratings[]', r));
            this.selectedColors.forEach(c => params.append('colors[]', c));
            this.selectedSizes.forEach(s => params.append('sizes[]', s));
            if (this.minPrice > 0) params.append('min_price', this.minPrice);
            if (this.maxPrice < 2000) params.append('max_price', this.maxPrice);
            if (this.search) params.append('search', this.search);
            if (this.sort) params.append('sort', this.sort);
            if (url) {
                const page = new URL(url).searchParams.get('page');
                if (page) params.set('page', page);
            }
            fetch(`${window.location.pathname}?${params.toString()}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(r => r.json())
            .then(data => {
                this.$refs.productContainer.innerHTML = data.products;
                this.$refs.paginationContainer.innerHTML = data.pagination;
                this.showingCount = (data.products.match(/group\s/g) || []).length;
            });
        }
    }
}
</script>
@endpush

@endsection
