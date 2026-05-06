<!DOCTYPE html>
<html lang="en" class="overflow-x-hidden">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @php
        $siteName  = \App\Models\Setting::get('site_name', config('app.name'));
        $siteTitle = \App\Models\Setting::get('site_title', 'Your Premium Shopping Destination');
        $favicon   = \App\Models\Setting::get('favicon', '');
    @endphp
    <title>@yield('title', $siteName . ($siteTitle ? ' - ' . $siteTitle : ''))</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    @if($favicon)
    <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $favicon) }}">
    <link rel="shortcut icon" href="{{ asset('storage/' . $favicon) }}">
    @endif

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

    <style>
        .fab-wrap { position:fixed; bottom:90px; right:20px; z-index:9999; display:flex; flex-direction:column; align-items:center; gap:12px; }
        .fab-btn {
            width:56px; height:56px; border-radius:50%; border:none; cursor:pointer;
            display:flex; align-items:center; justify-content:center;
            text-decoration:none; transition:transform 0.25s ease, box-shadow 0.25s ease;
            position:relative; flex-shrink:0;
        }
        .fab-btn:hover { transform:scale(1.12); }
        .fab-call  { background:linear-gradient(135deg,#3b82f6,#1d4ed8); box-shadow:0 6px 20px rgba(59,130,246,0.45); }
        .fab-wa    { background:linear-gradient(135deg,#25D366,#128C7E); box-shadow:0 6px 20px rgba(37,211,102,0.45); }
        .fab-toggle {
            width:60px; height:60px; border-radius:50%; border:none; cursor:pointer;
            display:flex; align-items:center; justify-content:center;
            background:linear-gradient(135deg,#25D366,#128C7E);
            box-shadow:0 6px 20px rgba(37,211,102,0.45);
            transition:transform 0.35s cubic-bezier(0.68,-0.55,0.265,1.55), background 0.3s, box-shadow 0.3s;
            outline:none; flex-shrink:0;
        }
        .fab-toggle.is-open {
            background:linear-gradient(135deg,#ef4444,#dc2626);
            box-shadow:0 6px 20px rgba(239,68,68,0.45);
            transform:rotate(135deg);
        }
        .fab-sub {
            display:flex; align-items:center; justify-content:center;
            overflow:hidden; max-height:0; opacity:0; pointer-events:none;
            transition:max-height 0.3s ease, opacity 0.3s ease, transform 0.3s ease;
            transform:translateY(8px);
        }
        .fab-sub.is-open {
            max-height:60px; opacity:1; pointer-events:auto; transform:translateY(0);
        }
        .fab-online-dot {
            position:absolute; top:3px; right:3px;
            width:13px; height:13px; background:#10b981;
            border-radius:50%; border:2px solid white;
        }
        @keyframes fab-pulse {
            0%,100% { box-shadow:0 6px 20px rgba(37,211,102,0.45), 0 0 0 0 rgba(37,211,102,0.4); }
            50%      { box-shadow:0 6px 20px rgba(37,211,102,0.45), 0 0 0 10px rgba(37,211,102,0); }
        }
        .fab-toggle:not(.is-open) { animation:fab-pulse 2.5s infinite; }
    </style>

    <div class="fab-wrap" id="fabWrap">

        <!-- Call Button -->
        @if($callPhone)
        <div class="fab-sub" id="fabCall">
            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $callPhone) }}" class="fab-btn fab-call" aria-label="Call us">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" width="24" height="24">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.13 11.8 19.79 19.79 0 0 1 1.06 3.18 2 2 0 0 1 3.04 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.09 8.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
                </svg>
            </a>
        </div>
        @endif

        <!-- WhatsApp Button -->
        @if($waPhone)
        <div class="fab-sub" id="fabWa">
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $waPhone) }}" target="_blank" rel="noopener" class="fab-btn fab-wa" aria-label="WhatsApp us">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" width="28" height="28">
                    <path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2zm.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 0 1 2.41 5.83c0 4.54-3.7 8.23-8.24 8.23-1.48 0-2.93-.39-4.19-1.15l-.3-.17-3.12.82.83-3.04-.2-.32a8.188 8.188 0 0 1-1.26-4.38c.01-4.54 3.7-8.24 8.25-8.24zm-1.52 5.66c-.16 0-.43.06-.66.31-.22.25-.87.86-.87 2.07 0 1.22.89 2.39 1 2.56.14.17 1.76 2.67 4.25 3.73.59.27 1.05.42 1.41.53.59.19 1.13.16 1.56.1.48-.07 1.46-.6 1.67-1.18.21-.58.21-1.07.15-1.18-.07-.1-.23-.16-.48-.27-.25-.14-1.47-.74-1.69-.82-.23-.08-.37-.12-.56.12-.16.25-.64.81-.78.97-.15.17-.29.19-.53.07-.26-.13-1.06-.39-2-1.23-.74-.66-1.23-1.47-1.38-1.72-.12-.24-.01-.39.11-.5.11-.11.27-.29.37-.44.13-.14.17-.25.25-.41.08-.17.04-.31-.02-.43-.06-.11-.56-1.35-.77-1.84-.2-.48-.4-.42-.56-.43-.14 0-.3-.01-.47-.01z"/>
                </svg>
                <span class="fab-online-dot"></span>
            </a>
        </div>
        @endif

        <!-- Toggle Button -->
        <button class="fab-toggle" id="fabToggle" aria-label="Contact options" aria-expanded="false">
            <!-- Chat / WhatsApp icon (closed state) -->
            <svg id="fabIconOpen" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" width="28" height="28">
                <path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2zm.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 0 1 2.41 5.83c0 4.54-3.7 8.23-8.24 8.23-1.48 0-2.93-.39-4.19-1.15l-.3-.17-3.12.82.83-3.04-.2-.32a8.188 8.188 0 0 1-1.26-4.38c.01-4.54 3.7-8.24 8.25-8.24zm-1.52 5.66c-.16 0-.43.06-.66.31-.22.25-.87.86-.87 2.07 0 1.22.89 2.39 1 2.56.14.17 1.76 2.67 4.25 3.73.59.27 1.05.42 1.41.53.59.19 1.13.16 1.56.1.48-.07 1.46-.6 1.67-1.18.21-.58.21-1.07.15-1.18-.07-.1-.23-.16-.48-.27-.25-.14-1.47-.74-1.69-.82-.23-.08-.37-.12-.56.12-.16.25-.64.81-.78.97-.15.17-.29.19-.53.07-.26-.13-1.06-.39-2-1.23-.74-.66-1.23-1.47-1.38-1.72-.12-.24-.01-.39.11-.5.11-.11.27-.29.37-.44.13-.14.17-.25.25-.41.08-.17.04-.31-.02-.43-.06-.11-.56-1.35-.77-1.84-.2-.48-.4-.42-.56-.43-.14 0-.3-.01-.47-.01z"/>
            </svg>
            <!-- X icon (open state) -->
            <svg id="fabIconClose" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" width="24" height="24" style="display:none;">
                <line x1="18" y1="6" x2="6" y2="18"/>
                <line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </button>

    </div>

    <script>
        (function () {
            var btn     = document.getElementById('fabToggle');
            var iconO   = document.getElementById('fabIconOpen');
            var iconC   = document.getElementById('fabIconClose');
            var subCall = document.getElementById('fabCall');
            var subWa   = document.getElementById('fabWa');
            var isOpen  = false;

            btn.addEventListener('click', function () {
                isOpen = !isOpen;
                btn.classList.toggle('is-open', isOpen);
                btn.setAttribute('aria-expanded', isOpen);
                iconO.style.display = isOpen ? 'none'  : '';
                iconC.style.display = isOpen ? ''      : 'none';
                if (subCall) subCall.classList.toggle('is-open', isOpen);
                if (subWa)   subWa.classList.toggle('is-open', isOpen);
            });
        })();
    </script>

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
