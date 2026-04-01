@php
    $footerPage = \App\Models\Page::where('slug', 'footer')->with('sections')->first();
    $footerSections = $footerPage ? $footerPage->sections->pluck('content', 'key') : collect();
    
    $companyInfo = $footerSections->get('company_info', []);
    $quickLinks = $footerSections->get('quick_links', []);
    $customerService = $footerSections->get('customer_service', []);
    $policies = $footerSections->get('policies', []);
    $contactInfo = $footerSections->get('contact_info', []);
    $bottomFooter = $footerSections->get('bottom_footer', []);
@endphp

<footer class="bg-white border-t border-gray-100 text-gray-600">
    <!-- Main Footer -->
    <div class="container mx-auto px-4 py-14">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-8">
            <!-- Company Info -->
            <div class="lg:col-span-2">
                <div class="mb-5">
                    <div class="h-16 flex items-center">
                        <img src="{{ isset($companyInfo['logo']) ? asset('storage/' . $companyInfo['logo']) : asset('images/shankhobazar.png') }}" alt="Shankhobazar Logo" class="h-full w-auto object-contain">
                    </div>
                </div>
                <p class="text-gray-500 mb-6 leading-relaxed text-sm">
                    {{ $companyInfo['description'] ?? 'Your premium shopping destination for quality products. We bring you the best deals, authentic products, and exceptional customer service.' }}
                </p>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="text-gray-900 font-bold text-sm uppercase tracking-wider mb-5">{{ $quickLinks['title'] ?? 'Quick Links' }}</h4>
                <ul class="space-y-3">
                    @php
                    $defaultLinks = [
                        ['name' => 'About Us', 'url' => '/about'],
                        ['name' => 'Contact Us', 'url' => '/contact'],
                        ['name' => 'Shop', 'url' => '/shop'],
                    ];
                    $links = $quickLinks['items'] ?? $defaultLinks;
                    @endphp
                    @foreach($links as $link)
                    <li>
                        <a href="{{ $link['url'] ?? '#' }}" class="text-sm text-gray-500 hover:text-primary transition duration-300 flex items-center gap-1.5">
                            <i class="fas fa-chevron-right text-[10px] text-primary"></i> {{ $link['name'] ?? '' }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            <!-- Customer Service -->
            <div>
                <h4 class="text-gray-900 font-bold text-sm uppercase tracking-wider mb-5">{{ $customerService['title'] ?? 'Customer Service' }}</h4>
                <ul class="space-y-3">
                    @foreach($customerService['items'] ?? [] as $link)
                    <li>
                        <a href="{{ $link['url'] ?? '#' }}" class="text-sm text-gray-500 hover:text-primary transition duration-300 flex items-center gap-1.5">
                            <i class="fas fa-chevron-right text-[10px] text-primary"></i> {{ $link['name'] ?? '' }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            <!-- Policies -->
            <div>
                <h4 class="text-gray-900 font-bold text-sm uppercase tracking-wider mb-5">{{ $policies['title'] ?? 'Policies' }}</h4>
                <ul class="space-y-3">
                    @foreach($policies['items'] ?? [] as $link)
                    <li>
                        <a href="{{ $link['url'] ?? '#' }}" class="text-sm text-gray-500 hover:text-primary transition duration-300 flex items-center gap-1.5">
                            <i class="fas fa-chevron-right text-[10px] text-primary"></i> {{ $link['name'] ?? '' }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h4 class="text-gray-900 font-bold text-sm uppercase tracking-wider mb-5">{{ $contactInfo['title'] ?? 'Contact Info' }}</h4>
                <ul class="space-y-3">
                    <li class="flex items-start gap-2 text-sm text-gray-500">
                        <i class="fas fa-map-marker-alt text-primary mt-0.5"></i>
                        <span>{{ $contactInfo['address'] ?? '123 Shopping Street, Dhaka 1200, Bangladesh' }}</span>
                    </li>
                </ul>

                <!-- Social Media Icons -->
                <div class="flex space-x-2 mt-6">
                    @foreach($companyInfo['items'] ?? [] as $social)
                    <a href="{{ $social['url'] ?? '#' }}" title="{{ $social['name'] ?? '' }}"
                       class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center hover:bg-primary hover:text-white text-gray-500 transition duration-300 text-xs">
                        <i class="{{ $social['icon'] ?? 'fab fa-facebook-f' }}"></i>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Footer -->
    <div class="border-t border-gray-100 bg-gray-50 py-5">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center gap-2">
                <p class="text-gray-400 text-xs">
                    &copy; {{ $bottomFooter['copyright_text'] ?? date('Y') . ' Shankhobazar. All rights reserved.' }}
                </p>
                <p class="text-gray-400 text-xs">
                    {{ $bottomFooter['credit_text'] ?? 'Designed and developed by' }}
                    <a href="{{ $bottomFooter['developer_url'] ?? 'https://alphainno.com' }}" target="_blank"
                       class="text-primary hover:underline font-medium">{{ $bottomFooter['developer_name'] ?? 'Alphainno' }}</a>
                </p>
            </div>
        </div>
    </div>
</footer>
