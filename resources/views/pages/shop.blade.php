@extends('layouts.app')

@section('title', 'Shop - Ecom Alpha')

@section('content')

<!-- Breadcrumb -->
<section class="bg-linear-to-r from-primary to-primary/80 text-white py-12">
    <div class="container mx-auto px-4">
        <nav class="flex items-center space-x-2 text-sm mb-4">
            <a href="/" class="hover:text-gray-200 transition">
                <i class="fas fa-home"></i> Home
            </a>
            <i class="fas fa-chevron-right text-xs"></i>
            <span class="text-gray-200">Shop</span>
        </nav>
        <h1 class="text-2xl md:text-3xl font-bold font-display">Our Shop</h1>
        <p class="text-gray-100 mt-1 text-sm">Discover amazing products at unbeatable prices</p>
    </div>
</section>

<!-- Shop Section -->
<section class="py-12 bg-gray-50" x-data="shopFilter()">
    <div class="container mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-8">

            <!-- Sidebar Filters -->
            <aside class="lg:w-1/4">
                <div class="bg-white rounded-2xl shadow-md p-6 sticky top-24">

                    <!-- Search -->
                    <div class="mb-8">
                        <h3 class="font-semibold text-sm text-gray-800 mb-3 flex items-center">
                            <i class="fas fa-search text-primary mr-2"></i> Search Products
                        </h3>
                        <div class="relative">
                            <input
                                type="text"
                                x-model="search"
                                @input.debounce.500ms="updateFilters()"
                                placeholder="Search..."
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary transition"
                            >
                            <button class="absolute right-3 top-3 text-gray-400 hover:text-primary transition">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Categories -->
                    <div class="mb-8 pb-8 border-b border-gray-200">
                        <h3 class="font-semibold text-sm text-gray-800 mb-3 flex items-center">
                            <i class="fas fa-th-large text-primary mr-2"></i> Categories
                        </h3>
                        <ul class="space-y-3">
                            <li>
                                <label class="flex items-center justify-between cursor-pointer group">
                                    <div class="flex items-center">
                                        <input type="checkbox"
                                               value=""
                                               x-model="allCategoriesSelected"
                                               @change="toggleAllCategories()"
                                               class="w-4 h-4 text-primary rounded focus:ring-primary">
                                        <span class="ml-3 text-sm font-semibold text-gray-700 group-hover:text-primary transition">All Categories</span>
                                    </div>
                                </label>
                            </li>
                            @foreach($categories as $category)
                            <li>
                                <label class="flex items-center justify-between cursor-pointer group">
                                    <div class="flex items-center">
                                        <input type="checkbox"
                                               value="{{ $category->id }}"
                                               x-model="selectedCategories"
                                               @change="updateFilters()"
                                               class="w-4 h-4 text-primary rounded focus:ring-primary">
                                        <span class="ml-3 text-sm text-gray-700 group-hover:text-primary transition">{{ $category->name }}</span>
                                    </div>
                                    <span class="text-xs text-gray-400 font-bold bg-gray-50 px-2 py-1 rounded-full">({{ $category->products_count ?? $category->products->count() }})</span>
                                </label>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Price Range -->
                    <div class="mb-8 pb-8 border-b border-gray-200">
                        <h3 class="font-semibold text-sm text-gray-800 mb-3 flex items-center">
                            <i class="fas fa-dollar-sign text-primary mr-2"></i> Price Range
                        </h3>
                        <div class="space-y-4">
                            <input type="range"
                                   min="0"
                                   max="2000"
                                   x-model="maxPrice"
                                   @input.debounce.500ms="updateFilters()"
                                   class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-primary">
                            <div class="flex items-center justify-between">
                                <input type="number"
                                       x-model="minPrice"
                                       @input.debounce.500ms="updateFilters()"
                                       placeholder="Min" class="w-24 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary text-sm">
                                <span class="text-gray-500">to</span>
                                <input type="number"
                                       x-model="maxPrice"
                                       @input.debounce.500ms="updateFilters()"
                                       placeholder="Max" class="w-24 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary text-sm">
                            </div>
                        </div>
                    </div>

                    <!-- Brands -->
                    <div class="mb-8 pb-8 border-b border-gray-200">
                        <h3 class="font-semibold text-sm text-gray-800 mb-3 flex items-center">
                            <i class="fas fa-tag text-primary mr-2"></i> Brands
                        </h3>
                        <ul class="space-y-3">
                            @foreach($allBrands as $brand)
                            <li>
                                <label class="flex items-center justify-between cursor-pointer group">
                                    <div class="flex items-center">
                                        <input type="checkbox"
                                               value="{{ $brand->id }}"
                                               x-model="selectedBrands"
                                               @change="updateFilters()"
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

                    <!-- Rating -->
                    <div class="mb-8 pb-8 border-b border-gray-200">
                        <h3 class="font-semibold text-sm text-gray-800 mb-3 flex items-center">
                            <i class="fas fa-star text-primary mr-2"></i> Rating
                        </h3>
                        <ul class="space-y-3">
                            @foreach([5, 4, 3] as $rating)
                            <li>
                                <label class="flex items-center cursor-pointer group">
                                    <input type="checkbox"
                                           value="{{ $rating }}"
                                           x-model="selectedRatings"
                                           @change="updateFilters()"
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

                    <!-- Color Filter -->
                    <div class="mb-8 pb-8 border-b border-gray-200">
                        <h3 class="font-semibold text-sm text-gray-800 mb-3 flex items-center">
                            <i class="fas fa-palette text-primary mr-2"></i> Colors
                        </h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($allColors as $color)
                            <button type="button"
                                    @click="toggleColor('{{ $color->color_name }}')"
                                    class="w-8 h-8 rounded-full border-2 transition-all duration-300 hover:scale-110 flex items-center justify-center relative"
                                    :class="selectedColors.includes('{{ $color->color_name }}') ? 'border-primary ring-2 ring-primary/20' : 'border-gray-200'"
                                    style="background-color: {{ $color->color_code }}"
                                    title="{{ $color->color_name }}">
                                <i x-show="selectedColors.includes('{{ $color->color_name }}')"
                                   class="fas fa-check text-[10px]"
                                   :class="'{{ $color->color_code }}' === '#FFFFFF' ? 'text-black' : 'text-white'"></i>
                            </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Size Filter -->
                    <div class="mb-8">
                        <h3 class="font-semibold text-sm text-gray-800 mb-3 flex items-center">
                            <i class="fas fa-ruler-combined text-primary mr-2"></i> Sizes
                        </h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($allSizes as $size)
                            <button type="button"
                                    @click="toggleSize('{{ $size->size_name }}')"
                                    class="px-3 py-2 border rounded-lg text-xs font-bold transition-all duration-300"
                                    :class="selectedSizes.includes('{{ $size->size_name }}') ? 'bg-primary text-white border-primary shadow-md' : 'bg-white text-gray-700 border-gray-200 hover:border-primary/30'">
                                {{ $size->size_name }}
                            </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Reset Filters -->
                    <button @click="resetFilters()" class="w-full bg-linear-to-r from-primary to-primary/80 text-white py-3 rounded-lg font-semibold hover:shadow-lg transition duration-300">
                        <i class="fas fa-redo mr-2"></i> Reset Filters
                    </button>
                </div>
            </aside>

            <!-- Products Grid -->
            <main class="lg:w-3/4">

                <!-- Toolbar -->
                <div class="bg-white rounded-2xl shadow-md p-6 mb-8">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div class="flex items-center space-x-4">
                            <p class="text-gray-600 text-sm">
                                Showing <span class="font-bold text-slate-900" x-text="showingCount">{{ $products->count() }}</span> results
                            </p>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4">
                            <!-- Sort -->
                            <select x-model="sort" @change="updateFilters()" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary transition text-sm font-semibold">
                                <option value="latest">Latest First</option>
                                <option value="price_low">Price: Low to High</option>
                                <option value="price_high">Price: High to Low</option>
                            </select>
                        </div>
                    </div>
                </div>

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

        init() {
            this.$watch('selectedCategories', (value) => {
                this.allCategoriesSelected = value.length === 0;
            });

            // Intercept pagination clicks
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
            if (this.allCategoriesSelected) {
                this.selectedCategories = [];
            }
            this.updateFilters();
        },

        toggleColor(color) {
            if (this.selectedColors.includes(color)) {
                this.selectedColors = this.selectedColors.filter(c => c !== color);
            } else {
                this.selectedColors.push(color);
            }
            this.updateFilters();
        },

        toggleSize(size) {
            if (this.selectedSizes.includes(size)) {
                this.selectedSizes = this.selectedSizes.filter(s => s !== size);
            } else {
                this.selectedSizes.push(size);
            }
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

            if (this.selectedCategories.length > 0) {
                this.selectedCategories.forEach(c => params.append('categories[]', c));
            }

            if (this.selectedBrands.length > 0) {
                this.selectedBrands.forEach(b => params.append('brands[]', b));
            }

            if (this.selectedRatings.length > 0) {
                this.selectedRatings.forEach(r => params.append('ratings[]', r));
            }

            if (this.selectedColors.length > 0) {
                this.selectedColors.forEach(c => params.append('colors[]', c));
            }

            if (this.selectedSizes.length > 0) {
                this.selectedSizes.forEach(s => params.append('sizes[]', s));
            }

            if (this.minPrice > 0) params.append('min_price', this.minPrice);
            if (this.maxPrice < 2000) params.append('max_price', this.maxPrice);
            if (this.search) params.append('search', this.search);
            if (this.sort) params.append('sort', this.sort);

            // Handle page from URL if it's a pagination click
            if (url) {
                const urlObj = new URL(url);
                const page = urlObj.searchParams.get('page');
                if (page) params.set('page', page);
            }

            fetch(`${window.location.pathname}?${params.toString()}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                this.$refs.productContainer.innerHTML = data.products;
                this.$refs.paginationContainer.innerHTML = data.pagination;

                // Update showing count
                const count = (data.products.match(/group\s/g) || []).length;
                this.showingCount = count;
            });
        }
    }
}
</script>
@endpush

@endsection
