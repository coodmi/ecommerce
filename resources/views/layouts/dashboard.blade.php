<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Shankhobazar</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@700;800;900&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary-color: {{ \App\Models\Setting::get('primary_color', '#9333ea') }};
        }
        [x-cloak] { display: none !important; }
        body {
            font-family: 'Inter', sans-serif;
            font-size: 14px;
        }
        .font-display {
            font-family: 'Playfair Display', serif;
        }

        /* ── Dashboard responsive typography ── */
        .dash-title   { font-size: clamp(1.1rem, 3vw, 1.375rem); font-weight: 700; }
        .dash-subtitle{ font-size: 0.8125rem; color: #6b7280; }
        .dash-stat    { font-size: clamp(1.25rem, 4vw, 1.75rem); font-weight: 700; }
        .dash-label   { font-size: 0.75rem; }

        /* Tighten Tailwind text sizes inside dashboard */
        .dashboard-content .text-3xl { font-size: clamp(1.1rem, 3vw, 1.375rem) !important; }
        .dashboard-content .text-2xl { font-size: clamp(1rem, 2.5vw, 1.2rem)   !important; }
        .dashboard-content .text-xl  { font-size: 1rem !important; }
        .dashboard-content .text-lg  { font-size: 0.9375rem !important; }
        .dashboard-content .text-base{ font-size: 0.875rem !important; }
        .dashboard-content .text-sm  { font-size: 0.8125rem !important; }
        .dashboard-content .text-xs  { font-size: 0.75rem !important; }

        /* Responsive padding */
        .dashboard-content .p-6 { padding: 1rem; }
        @media (min-width: 640px) {
            .dashboard-content .p-6 { padding: 1.5rem; }
        }

        @keyframes slideIn {
            from { transform: translateX(-100%); }
            to { transform: translateX(0); }
        }
        .sidebar-animate {
            animation: slideIn 0.3s ease-out;
        }
        button, a, label[for], select, option,
        [type="button"], [type="submit"], [type="reset"],
        [role="button"], .cursor-pointer { cursor: pointer; }

        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.2); }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar Component (Role-based) -->
        @if(Auth::user()->isAdmin())
            @include('components.sidebar-admin')
        @elseif(Auth::user()->isSeller())
            @include('components.sidebar-seller')
        @else
            @include('components.sidebar-user')
        @endif

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navigation Component -->
            @include('components.topbar')

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-gray-50 no-scrollbar">
                <div class="min-h-[calc(100vh-64px)] flex flex-col dashboard-content">
                    <div class="flex-1">
                        @yield('content')
                    </div>
                    
                    <!-- Admin Dashboard Footer -->
                    <footer class="mt-auto px-6 py-8 border-t border-gray-200 bg-white/50">
                        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                @php
                                    $ftInfo = $globalFooterConfig->get('company_info', []);
                                    $ftLogo = isset($ftInfo['logo']) ? asset('storage/' . $ftInfo['logo']) : asset('images/shankhobazar.png');
                                @endphp
                                <img src="{{ $ftLogo }}" alt="Footer Logo" class="h-8 w-auto grayscale opacity-50 hover:grayscale-0 hover:opacity-100 transition-all">
                                <span class="text-xs text-gray-400 font-medium">
                                    {{ $globalFooterConfig->get('bottom_footer', [])['copyright_text'] ?? '© ' . date('Y') . ' Shankhobazar. All rights reserved.' }}
                                </span>
                            </div>
                            <div class="flex items-center gap-2 text-[10px] text-gray-400 uppercase tracking-widest font-bold">
                                <span>Powered by</span>
                                <span class="text-primary">{{ $globalFooterConfig->get('bottom_footer', [])['developer_name'] ?? 'Ecom Alpha' }}</span>
                            </div>
                        </div>
                    </footer>
                </div>
            </main>
        </div>
    </div>

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

    <!-- Scripts -->
    <script>
        // Sidebar logic
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            const openSidebarBtn = document.getElementById('openSidebar');
            const closeSidebarBtn = document.getElementById('closeSidebar');

            if (openSidebarBtn) {
                openSidebarBtn.addEventListener('click', () => {
                    sidebar.classList.remove('-translate-x-full');
                    sidebarOverlay.classList.remove('hidden');
                });
            }

            if (closeSidebarBtn) {
                closeSidebarBtn.addEventListener('click', () => {
                    sidebar.classList.add('-translate-x-full');
                    sidebarOverlay.classList.add('hidden');
                });
            }

            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', () => {
                    sidebar.classList.add('-translate-x-full');
                    sidebarOverlay.classList.add('hidden');
                });
            }
        });

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
                                setTimeout(() => window.location.reload(), 1000);
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
    </script>
</body>
</html>
