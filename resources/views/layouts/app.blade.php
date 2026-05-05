<!DOCTYPE html>
<html lang="en" class="overflow-x-hidden">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Shankhobazar - Your Premium Shopping Destination')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary-color: {{ \App\Models\Setting::get('primary_color', '#9333ea') }};
            --secondary-color: {{ \App\Models\Setting::get('secondary_color', '#FFDF20') }};
        }
        body {
            font-family: 'Poppins', sans-serif;
            font-size: 15px;
        }
        .font-display {
            font-family: 'Montserrat', sans-serif;
        }
        /* Cursor pointer for all interactive elements */
        button,
        a,
        label[for],
        select,
        option,
        [type="button"],
        [type="submit"],
        [type="reset"],
        [role="button"],
        .cursor-pointer {
            cursor: pointer;
        }
    </style>
</head>
<body class="bg-gray-50 overflow-x-hidden">
    <!-- Header -->
    @include('components.header')

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @include('components.footer')

    <!-- Floating Contact Buttons -->
    @php
        $waPhone   = \App\Models\Setting::get('whatsapp_number', '');
        $callPhone = \App\Models\Setting::get('call_number', '');
    @endphp
    <div x-data="{ open: false }" style="position:fixed;bottom:100px;right:20px;z-index:9999;display:flex;flex-direction:column;align-items:center;gap:12px;">

        <!-- Call Button -->
        @if($callPhone)
        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $callPhone) }}"
           x-show="open"
           style="display:none;width:56px;height:56px;background:#3b82f6;color:white;border-radius:50%;box-shadow:0 4px 15px rgba(0,0,0,0.3);align-items:center;justify-content:center;text-decoration:none;transition:transform 0.2s;"
           onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
            <i class="fas fa-phone" style="font-size:20px;"></i>
        </a>
        @endif

        <!-- WhatsApp Button -->
        @if($waPhone)
        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $waPhone) }}" target="_blank" rel="noopener"
           x-show="open"
           style="display:none;width:56px;height:56px;background:#25D366;color:white;border-radius:50%;box-shadow:0 4px 15px rgba(0,0,0,0.3);align-items:center;justify-content:center;text-decoration:none;position:relative;transition:transform 0.2s;"
           onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:28px;height:28px;">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
            </svg>
            <span style="position:absolute;top:2px;right:2px;width:12px;height:12px;background:#86efac;border-radius:50%;border:2px solid white;"></span>
        </a>
        @endif

        <!-- Toggle Button -->
        <button @click="open = !open"
                style="width:56px;height:56px;border-radius:50%;box-shadow:0 4px 20px rgba(0,0,0,0.3);border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all 0.3s;"
                :style="open ? 'background:#ef4444;' : 'background:#25D366;'"
                onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
            <i class="fas text-white"
               style="font-size:22px;color:white;"
               :class="open ? 'fa-times' : 'fa-comment-dots'"></i>
        </button>

    </div>

    <button id="scrollToTop" class="fixed bottom-8 right-6 bg-gradient-to-r from-primary to-primary/80 text-white p-4 rounded-full shadow-lg hover:shadow-xl transition-all duration-300 opacity-0 invisible hover:scale-110 z-50">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Global Notification/Toast Component -->
    <div x-data="toastComponent()" 
         @toast.window="add($event.detail)" 
         class="fixed top-4 right-4 z-[9999] space-y-3 pointer-events-none">
        <template x-for="toast in toasts" :key="toast.id">
            <div x-show="toast.show"
                 x-transition:enter="transition ease-out duration-300 transform"
                 x-transition:enter-start="translate-x-full opacity-0"
                 x-transition:enter-end="translate-x-0 opacity-100"
                 x-transition:leave="transition ease-in duration-200 transform"
                 x-transition:leave-start="translate-x-0 opacity-100"
                 x-transition:leave-end="translate-x-full opacity-0"
                 class="w-80 pointer-events-auto bg-white rounded-2xl shadow-2xl border-l-4 p-4 flex items-start space-x-3"
                 :class="{
                     'border-green-500 bg-green-50': toast.type === 'success',
                     'border-red-500 bg-red-50': toast.type === 'error',
                     'border-blue-500 bg-blue-50': toast.type === 'info',
                     'border-yellow-500 bg-yellow-50': toast.type === 'warning'
                 }">
                <div class="flex-shrink-0 mt-0.5">
                    <template x-if="toast.type === 'success'"><i class="fas fa-check-circle text-green-500"></i></template>
                    <template x-if="toast.type === 'error'"><i class="fas fa-exclamation-circle text-red-500"></i></template>
                    <template x-if="toast.type === 'info'"><i class="fas fa-info-circle text-blue-500"></i></template>
                    <template x-if="toast.type === 'warning'"><i class="fas fa-exclamation-triangle text-yellow-500"></i></template>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-bold text-gray-900" x-text="toast.title || 'Notification'"></p>
                    <p class="text-xs text-gray-600 mt-1" x-text="toast.message"></p>
                </div>
                <button @click="remove(toast.id)" class="text-gray-400 hover:text-gray-600 transition-colors cursor-pointer">
                    <i class="fas fa-times text-xs"></i>
                </button>
            </div>
        </template>
    </div>

    <!-- Global Custom Confirmation Modal Component -->
    <div x-data="confirmModalComponent()" 
         @confirm-modal.window="openModal($event.detail)"
         x-show="isOpen" 
         class="fixed inset-0 z-[9998] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         style="display: none;">
        <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full overflow-hidden"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="scale-90 opacity-0"
             x-transition:enter-end="scale-100 opacity-100">
            <div class="p-6 text-center">
                <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4"
                     :class="{
                         'bg-red-100 text-red-600': config.type === 'danger',
                         'bg-yellow-100 text-yellow-600': config.type === 'warning',
                         'bg-blue-100 text-blue-600': config.type === 'info'
                     }">
                    <i class="fas fa-3xl" :class="config.icon"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 font-display mb-2" x-text="config.title"></h3>
                <p class="text-gray-600" x-text="config.message"></p>
            </div>
            <div class="p-6 bg-gray-50 flex space-x-3">
                <button @click="closeModal()" 
                        class="flex-1 py-3 px-4 bg-white border border-gray-300 text-gray-700 rounded-xl font-semibold hover:bg-gray-100 transition-all">
                    Cancel
                </button>
                <button @click="confirmAction()" 
                        class="flex-1 py-3 px-4 text-white rounded-xl font-semibold transition-all hover:shadow-lg"
                        :class="{
                            'bg-red-600 hover:bg-red-700': config.type === 'danger',
                            'bg-yellow-600 hover:bg-yellow-700': config.type === 'warning',
                            'bg-blue-600 hover:bg-blue-700': config.type === 'info'
                        }"
                        x-text="config.confirmText">
                </button>
            </div>
        </div>
    </div>

    <script>
        // Scroll to top functionality
        const scrollToTopBtn = document.getElementById('scrollToTop');

        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                scrollToTopBtn.classList.remove('opacity-0', 'invisible');
            } else {
                scrollToTopBtn.classList.add('opacity-0', 'invisible');
            }
        });

        scrollToTopBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');

        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });
        }

        // Toast Component Function
        function toastComponent() {
            return {
                toasts: [],
                add(data) {
                    const id = Date.now();
                    this.toasts.push({
                        id: id,
                        show: true,
                        type: data.type || 'info',
                        title: data.title || (data.type === 'success' ? 'Success!' : 'Error!'),
                        message: data.message || '',
                    });
                    setTimeout(() => { this.remove(id); }, 5000);
                },
                remove(id) {
                    const index = this.toasts.findIndex(t => t.id === id);
                    if (index > -1) {
                        this.toasts[index].show = false;
                        setTimeout(() => {
                            this.toasts = this.toasts.filter(t => t.id !== id);
                        }, 3000);
                    }
                },
                init() {
                    @if(session('success'))
                        this.add({ type: 'success', message: @json(session('success')) });
                    @endif
                    @if(session('error'))
                        this.add({ type: 'error', message: @json(session('error')) });
                    @endif
                    @if($errors->any())
                        @foreach($errors->all() as $error)
                            this.add({ 
                                type: 'error', 
                                title: 'Validation Error', 
                                message: @json($error)
                            });
                        @endforeach
                    @endif
                }
            }
        }

        // Confirmation Modal Component Function
        function confirmModalComponent() {
            return {
                isOpen: false,
                formToSubmit: null,
                config: {
                    type: 'info',
                    icon: 'fa-info-circle',
                    title: 'Are you sure?',
                    message: 'You are about to perform this action.',
                    confirmText: 'Confirm'
                },
                openModal(detail) {
                    this.config = {
                        type: detail.type || 'info',
                        icon: detail.icon || 'fa-info-circle',
                        title: detail.title || 'Are you sure?',
                        message: detail.message || 'You are about to perform this action.',
                        confirmText: detail.confirmText || 'Confirm',
                        ajax: detail.ajax || false,
                        url: detail.url || null,
                        method: detail.method || 'POST',
                        callback: detail.callback || null
                    };
                    this.formToSubmit = detail.formId ? document.getElementById(detail.formId) : null;
                    this.isOpen = true;
                },
                closeModal() {
                    this.isOpen = false;
                },
                confirmAction() {
                    if (this.config.ajax && this.config.url) {
                        fetch(this.config.url, {
                            method: this.config.method || 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                window.dispatchEvent(new CustomEvent('toast', {
                                    detail: { type: 'success', message: data.message }
                                }));
                                if (data.redirect) {
                                    setTimeout(() => { window.location.href = data.redirect; }, 1000);
                                } else {
                                    setTimeout(() => { window.location.reload(); }, 1000);
                                }
                            } else {
                                window.dispatchEvent(new CustomEvent('toast', {
                                    detail: { type: 'error', message: data.message }
                                }));
                            }
                        })
                        .catch(error => {
                            window.dispatchEvent(new CustomEvent('toast', {
                                detail: { type: 'error', message: 'An error occurred.' }
                            }));
                        });
                    } else if (this.formToSubmit) {
                        this.formToSubmit.submit();
                    } else if (this.config.callback && typeof this.config.callback === 'function') {
                        this.config.callback();
                    }
                    this.closeModal();
                }
            }
        }

        // Wishlist Toggle Function
        function toggleWishlist(productId) {
            fetch(`/wishlist/toggle/${productId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(async response => {
                const data = await response.json();
                if (response.status === 401) {
                    window.location.href = '/login';
                    return;
                }
                
                if (response.ok) {
                    window.dispatchEvent(new CustomEvent('toast', {
                        detail: { 
                            type: 'success', 
                            title: data.status === 'added' ? 'Added to Wishlist' : 'Removed from Wishlist',
                            message: data.message 
                        }
                    }));
                    // Reload if on wishlist page
                    if (window.location.pathname === '/wishlist') {
                        setTimeout(() => window.location.reload(), 1000);
                    }
                } else {
                    window.dispatchEvent(new CustomEvent('toast', {
                        detail: { type: 'error', message: data.message || 'Something went wrong' }
                    }));
                }
            })
            .catch(error => {
                console.error('Wishlist error:', error);
                window.dispatchEvent(new CustomEvent('toast', {
                    detail: { type: 'error', message: 'An error occurred.' }
                }));
            });
        }
    </script>
    @stack('scripts')
</body>
</html>
