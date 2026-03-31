@extends('layouts.dashboard')

@section('content')
<div class="px-6 py-6">
    <!-- Success Message -->
    @if(session('success'))
    <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-3">
        <i class="fas fa-check-circle text-green-500"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Pages Management</h1>
            <p class="text-slate-500 text-sm mt-1">Manage content for all website pages. Edit dynamic sections like hero banners and CTAs.</p>
        </div>
    </div>

    <!-- Pages Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        @forelse($pages as $page)
            @php
                // Determine page icon and color based on slug
                $iconConfigs = [
                    'home' => ['icon' => 'fa-home', 'color' => 'blue', 'desc' => 'Main landing page of your store'],
                    'header' => ['icon' => 'fa-window-maximize', 'color' => 'indigo', 'desc' => 'Global website header, navigation menu and top bar'],
                    'categories' => ['icon' => 'fa-th-large', 'color' => 'purple', 'desc' => 'Category browsing page with hero & banner sections'],
                    'deals' => ['icon' => 'fa-fire', 'color' => 'orange', 'desc' => 'Daily deals and flash sale page'],
                    'about-us' => ['icon' => 'fa-info-circle', 'color' => 'amber', 'desc' => 'About your company and team information'],
                    'contact-us' => ['icon' => 'fa-envelope', 'color' => 'pink', 'desc' => 'Contact form, map and office details'],
                    'footer' => ['icon' => 'fa-shoe-prints', 'color' => 'slate', 'desc' => 'Global website footer, social links and copyrights'],
                    'privacy-policy' => ['icon' => 'fa-shield-alt', 'color' => 'green', 'desc' => 'Privacy policy page content'],
                    'terms-conditions' => ['icon' => 'fa-file-contract', 'color' => 'blue', 'desc' => 'Terms and conditions page content'],
                    'refund-policy' => ['icon' => 'fa-undo-alt', 'color' => 'yellow', 'desc' => 'Refund and return policy content'],
                ];
                $config = $iconConfigs[$page->slug] ?? ['icon' => 'fa-file-alt', 'color' => 'slate', 'desc' => 'Page content'];
                $hasEditableSections = in_array($page->slug, ['home', 'header', 'categories', 'deals', 'about-us', 'contact-us', 'footer', 'privacy-policy', 'terms-conditions', 'refund-policy']);
            @endphp
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-lg transition-all group">
                <div class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-12 h-12 rounded-xl bg-{{ $config['color'] }}-100 flex items-center justify-center text-{{ $config['color'] }}-600 group-hover:scale-110 transition-transform overflow-hidden px-1 py-1">
                            @php
                                $headerLogo = $globalHeaderConfig->get('brand', [])['logo'] ?? null;
                                $footerLogo = $globalFooterConfig->get('company_info', [])['logo'] ?? null;
                            @endphp
                            @if($page->slug === 'header' && $headerLogo)
                                <img src="{{ asset('storage/' . $headerLogo) }}" class="w-full h-full object-contain">
                            @elseif($page->slug === 'footer' && $footerLogo)
                                <img src="{{ asset('storage/' . $footerLogo) }}" class="w-full h-full object-contain">
                            @else
                                <i class="fas {{ $config['icon'] }} text-xl"></i>
                            @endif
                        </div>
                        @if($hasEditableSections)
                            <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">Editable</span>
                        @else
                            <span class="px-2 py-1 bg-slate-100 text-slate-500 text-xs font-bold rounded-full">Static</span>
                        @endif
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-1">{{ $page->name }}</h3>
                    <p class="text-sm text-slate-500 mb-4">{{ $config['desc'] }}</p>
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-slate-400 font-mono bg-slate-50 px-2 py-1 rounded">/{{ $page->slug }}</span>
                        @if($hasEditableSections)
                            <a href="{{ route('admin.pages.edit', $page->id) }}" class="inline-flex items-center px-4 py-2 bg-linear-to-r from-purple-600 to-pink-600 text-white rounded-lg text-sm font-bold hover:shadow-lg hover:shadow-purple-500/30 hover:scale-105 transition-all transform">
                                <i class="fas fa-edit mr-2"></i> Edit Content
                            </a>
                        @else
                            <span class="text-xs text-slate-400 italic">No dynamic sections</span>
                        @endif
                    </div>
                </div>
            </div>
        @empty
        <div class="col-span-full">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-12 text-center">
                <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-file-alt text-slate-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-medium text-slate-900">No Pages Found</h3>
                <p class="text-slate-500 mt-1">Run the seeder to populate default pages.</p>
                <code class="inline-block mt-4 bg-slate-100 text-slate-700 px-4 py-2 rounded-lg text-sm font-mono">php artisan db:seed --class=PageSeeder</code>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Info Section -->
    <div class="bg-linear-to-r from-purple-50 to-pink-50 rounded-2xl border border-purple-100 p-6">
        <div class="flex items-start gap-4">
            <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center text-primary flex-shrink-0">
                <i class="fas fa-lightbulb"></i>
            </div>
            <div>
                <h3 class="font-bold text-slate-800 mb-2">How Pages Management Works</h3>
                <ul class="text-sm text-slate-600 space-y-1">
                    <li><i class="fas fa-check text-green-500 mr-2"></i><strong>Dynamic Sections:</strong> Edit hero banners, CTAs, story features, and team members across all main pages.</li>
                    <li><i class="fas fa-check text-green-500 mr-2"></i><strong>Global Footer:</strong> Manage logo, socials, multi-column links, and contact info in one place.</li>
                    <li><i class="fas fa-sync text-purple-500 mr-2"></i><strong>Changes are instant:</strong> Updates reflect immediately on the frontend.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
