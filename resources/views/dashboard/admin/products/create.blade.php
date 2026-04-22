@extends('layouts.dashboard')

@section('title', 'Create Product')

@section('content')
<div class="p-6">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center space-x-4 mb-4">
            <a href="{{ route('admin.products.index') }}"
               class="text-gray-600 hover:text-gray-900 transition">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h1 class="dash-title text-gray-900">Create Product</h1>
                <p class="text-gray-600 mt-1">Add a new product to your inventory</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.products.store') }}"
          method="POST"
          enctype="multipart/form-data"
          x-data="productForm()">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Information -->
                <div class="bg-white rounded-2xl shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Basic Information</h2>

                    <div class="space-y-4">
                        <!-- Product Name -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Product Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   name="name"
                                   value="{{ old('name') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-primary transition @error('name') border-red-500 @enderror"
                                   placeholder="Enter product name"
                                   required>
                            @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Description
                            </label>
                            <textarea name="description"
                                      rows="5"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-primary transition @error('description') border-red-500 @enderror"
                                      placeholder="Enter product description">{{ old('description') }}</textarea>
                            @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Price and SKU -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Base Price <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                                    <input type="number"
                                           name="base_price"
                                           value="{{ old('base_price') }}"
                                           step="0.01"
                                           min="0"
                                           class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-primary transition @error('base_price') border-red-500 @enderror"
                                           placeholder="0.00"
                                           required>
                                </div>
                                @error('base_price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    SKU
                                </label>
                                <input type="text"
                                       name="sku"
                                       value="{{ old('sku') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-primary transition @error('sku') border-red-500 @enderror"
                                       placeholder="Product SKU">
                                @error('sku')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Stock Quantity -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Stock Quantity <span class="text-red-500">*</span>
                            </label>
                            <input type="number"
                                   name="stock_quantity"
                                   value="{{ old('stock_quantity', 0) }}"
                                   min="0"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-primary transition @error('stock_quantity') border-red-500 @enderror"
                                   placeholder="0"
                                   required>
                            @error('stock_quantity')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Product Images -->
                <div class="bg-white rounded-2xl shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Product Images</h2>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Upload Images (Multiple)
                        </label>
                        <input type="file"
                               name="images[]"
                               multiple
                               accept="image/*"
                               x-ref="imageInput"
                               @change="handleImageUpload($event)"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-primary transition">
                        <p class="mt-1 text-sm text-gray-500">You can select multiple images. First image will be the primary image.</p>

                        <!-- Image Previews -->
                        <div x-show="imagePreviews.length > 0" class="mt-4 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                            <template x-for="(preview, index) in imagePreviews" :key="index">
                                <div class="relative group">
                                    <img :src="preview" class="w-full h-32 object-cover rounded-lg border-2 border-gray-300">
                                    <div x-show="index === 0" class="absolute top-2 left-2 px-2 py-1 bg-primary text-white text-xs rounded">
                                        Primary
                                    </div>
                                    <button type="button"
                                            @click="removeImage(index)"
                                            class="absolute top-2 right-2 w-6 h-6 bg-red-500 text-white rounded-full opacity-0 group-hover:opacity-100 transition">
                                        <i class="fas fa-times text-xs"></i>
                                    </button>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Colors (Optional) -->
                <div class="bg-white rounded-2xl shadow-md p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-900">Colors (Optional)</h2>
                        <button type="button"
                                @click="addColor()"
                                class="px-4 py-2 bg-purple-100 text-purple-700 rounded-lg hover:bg-purple-200 transition">
                            <i class="fas fa-plus mr-2"></i>Add Color
                        </button>
                    </div>

                    {{-- Hidden input carries the serialized colors array --}}
                    <input type="hidden" name="colors_json" :value="JSON.stringify(colors)">

                    <div class="space-y-3">
                        <template x-for="(colorItem, index) in colors" :key="index">
                            <div class="flex items-center space-x-3 bg-gray-50 p-3 rounded-xl border border-gray-100">
                                <input type="text"
                                       x-model="colors[index].name"
                                       @input="handleColorNameChange(index)"
                                       class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-primary transition"
                                       placeholder="Color name (e.g., Red)">
                                <div class="flex flex-col items-center">
                                    <input type="color"
                                           x-model="colors[index].code"
                                           class="w-16 h-12 border border-gray-300 rounded-xl cursor-pointer">
                                    <span x-text="colors[index].code" class="text-[10px] text-gray-400 mt-1 font-mono uppercase"></span>
                                </div>
                                <button type="button"
                                        @click="removeColor(index)"
                                        class="px-4 py-3 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </template>
                        <p x-show="colors.length === 0" class="text-gray-500 text-sm">No colors added. Click "Add Color" to add product colors.</p>
                    </div>
                </div>

                <!-- Sizes (Optional) -->
                <div class="bg-white rounded-2xl shadow-md p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-900">Sizes (Optional)</h2>
                        <button type="button"
                                @click="addSize()"
                                class="px-4 py-2 bg-purple-100 text-purple-700 rounded-lg hover:bg-purple-200 transition">
                            <i class="fas fa-plus mr-2"></i>Add Size
                        </button>
                    </div>

                    <div class="space-y-3">
                        {{-- Hidden input carries the serialized sizes array --}}
                        <input type="hidden" name="sizes_json" :value="JSON.stringify(sizes)">

                        <template x-for="(sizeItem, index) in sizes" :key="index">
                            <div class="flex items-center space-x-3">
                                <input type="text"
                                       x-model="sizes[index].name"
                                       class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-primary transition"
                                       placeholder="Size name (e.g., S, M, L, XL)">
                                <button type="button"
                                        @click="removeSize(index)"
                                        class="px-4 py-3 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </template>
                        <p x-show="sizes.length === 0" class="text-gray-500 text-sm">No sizes added. Click "Add Size" to add product sizes.</p>
                    </div>
                </div>

                <!-- Variant Pricing -->
                <div x-show="colors.length > 0 || sizes.length > 0" class="bg-white rounded-2xl shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Variant Pricing</h2>
                    <p class="text-sm text-gray-600 mb-4">Set specific prices for color/size combinations. Leave blank to use base price.</p>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th x-show="colors.length > 0" class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Color</th>
                                    <th x-show="sizes.length > 0" class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Size</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Price</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Stock</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">SKU</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="(variant, vIndex) in generateVariants()" :key="vIndex">
                                    <tr class="border-t border-gray-200">
                                        <td x-show="colors.length > 0" class="px-4 py-3">
                                            <span x-text="variant.colorName" class="text-sm"></span>
                                            <input type="hidden" :name="'variants[' + vIndex + '][color_id]'" :value="variant.colorId">
                                        </td>
                                        <td x-show="sizes.length > 0" class="px-4 py-3">
                                            <span x-text="variant.sizeName" class="text-sm"></span>
                                            <input type="hidden" :name="'variants[' + vIndex + '][size_id]'" :value="variant.sizeId">
                                        </td>
                                        <td class="px-4 py-3">
                                            <input type="number"
                                                   :name="'variants[' + vIndex + '][price]'"
                                                   step="0.01"
                                                   min="0"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary"
                                                   placeholder="0.00">
                                        </td>
                                        <td class="px-4 py-3">
                                            <input type="number"
                                                   :name="'variants[' + vIndex + '][stock]'"
                                                   min="0"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary"
                                                   placeholder="0">
                                        </td>
                                        <td class="px-4 py-3">
                                            <input type="text"
                                                   :name="'variants[' + vIndex + '][sku]'"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary"
                                                   placeholder="SKU">
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Category -->
                <div class="bg-white rounded-2xl shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Organization</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Select Category <span class="text-red-500">*</span>
                            </label>
                            <select name="category_id"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-primary transition @error('category_id') border-red-500 @enderror"
                                    required>
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('category_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Select Brand
                            </label>
                            <select name="brand_id"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-primary transition @error('brand_id') border-red-500 @enderror">
                                <option value="">No Brand</option>
                                @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('brand_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Rating -->
                <div class="bg-white rounded-2xl shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Product Rating</h2>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Initial Rating (0-5)
                        </label>
                        <input type="number"
                               name="rating"
                               value="{{ old('rating', 0) }}"
                               min="0"
                               max="5"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-primary transition @error('rating') border-red-500 @enderror"
                               placeholder="Enter rating">
                        @error('rating')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Status -->
                <div class="bg-white rounded-2xl shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Status & Visibility</h2>
                    <div class="space-y-4">
                        <label class="flex items-center space-x-3">
                            <input type="checkbox"
                                   name="is_active"
                                   value="1"
                                   {{ old('is_active', true) ? 'checked' : '' }}
                                   class="w-5 h-5 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                            <span class="text-sm font-semibold text-gray-700">Active</span>
                        </label>

                        <label class="flex items-center space-x-3">
                            <input type="checkbox"
                                   name="is_deal"
                                   value="1"
                                   {{ old('is_deal') ? 'checked' : '' }}
                                   class="w-5 h-5 text-amber-600 border-gray-300 rounded focus:ring-amber-500">
                            <span class="text-sm font-semibold text-gray-700">Deal Product</span>
                        </label>
                    </div>
                    <p class="mt-4 text-xs text-gray-500">Active: Product will be visible to customers</p>
                    <p class="mt-1 text-xs text-gray-500">Deal Product: Product will be featured on the Deals page</p>
                </div>

                <!-- Actions -->
                <div class="bg-white rounded-2xl shadow-md p-6">
                    <div class="space-y-3">
                        <button type="submit"
                                class="w-full px-6 py-3 bg-linear-to-r from-purple-600 to-pink-600 text-white rounded-xl font-semibold hover:shadow-lg transition">
                            <i class="fas fa-save mr-2"></i>Create Product
                        </button>
                        <a href="{{ route('admin.products.index') }}"
                           class="block w-full px-6 py-3 bg-gray-200 text-gray-700 text-center rounded-xl font-semibold hover:bg-gray-300 transition">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
function productForm() {
    return {
        imagePreviews: [],
        imageFiles: [],
        colors: [],
        sizes: [],

        handleImageUpload(event) {
            const files = Array.from(event.target.files);

            files.forEach(file => {
                this.imageFiles.push(file);
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.imagePreviews.push(e.target.result);
                };
                reader.readAsDataURL(file);
            });

            this.syncFilesToInput();
        },

        removeImage(index) {
            this.imagePreviews.splice(index, 1);
            this.imageFiles.splice(index, 1);
            this.syncFilesToInput();
        },

        syncFilesToInput() {
            const dataTransfer = new DataTransfer();
            this.imageFiles.forEach(file => dataTransfer.items.add(file));
            this.$refs.imageInput.files = dataTransfer.files;
        },

        addColor() {
            this.colors.push({ name: '', code: '#000000' });
        },

        removeColor(index) {
            window.dispatchEvent(new CustomEvent('confirm-modal', {
                detail: {
                    type: 'danger',
                    icon: 'fa-palette',
                    title: 'Remove Color',
                    message: 'Are you sure you want to remove this color?',
                    confirmText: 'Remove',
                    callback: () => {
                        this.colors.splice(index, 1);
                    }
                }
            }));
        },

        addSize() {
            this.sizes.push({ name: '' });
        },

        removeSize(index) {
            window.dispatchEvent(new CustomEvent('confirm-modal', {
                detail: {
                    type: 'danger',
                    icon: 'fa-ruler-combined',
                    title: 'Remove Size',
                    message: 'Are you sure you want to remove this size?',
                    confirmText: 'Remove',
                    callback: () => {
                        this.sizes.splice(index, 1);
                    }
                }
            }));
        },

        // New helper to handle color name changes
        handleColorNameChange(index) {
            const colorNames = {
                'white': '#FFFFFF',
                'black': '#000000',
                'red': '#FF0000',
                'blue': '#0000FF',
                'green': '#008000',
                'yellow': '#FFFF00',
                'purple': '#800080',
                'orange': '#FFA500',
                'pink': '#FFC0CB',
                'gray': '#808080',
                'grey': '#808080',
                'brown': '#A52A2A',
                'silver': '#C0C0C0',
                'gold': '#FFD700',
                'cyan': '#00FFFF',
                'magenta': '#FF00FF'
            };

            const name = this.colors[index].name.toLowerCase().trim();
            if (colorNames[name]) {
                this.colors[index].code = colorNames[name];
            }
        },

        generateVariants() {
            const variants = [];

            if (this.colors.length > 0 && this.sizes.length > 0) {
                this.colors.forEach((color, cIndex) => {
                    this.sizes.forEach((size, sIndex) => {
                        variants.push({
                            colorId: cIndex, sizeId: sIndex,
                            colorName: color.name || 'Color ' + (cIndex + 1),
                            sizeName: size.name || 'Size ' + (sIndex + 1)
                        });
                    });
                });
            } else if (this.colors.length > 0) {
                this.colors.forEach((color, cIndex) => {
                    variants.push({
                        colorId: cIndex, sizeId: '',
                        colorName: color.name || 'Color ' + (cIndex + 1), sizeName: ''
                    });
                });
            } else if (this.sizes.length > 0) {
                this.sizes.forEach((size, sIndex) => {
                    variants.push({
                        colorId: '', sizeId: sIndex,
                        colorName: '', sizeName: size.name || 'Size ' + (sIndex + 1)
                    });
                });
            }

            return variants;
        }
    }
}
</script>
@endsection
