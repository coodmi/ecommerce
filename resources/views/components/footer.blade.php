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

<footer class="bg-gray-900 text-gray-300">
    <!-- Main Footer -->
    <div class="container mx-auto px-4 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-8">
            <!-- Company Info -->
            <div class="lg:col-span-2">
                <div class="mb-6">
                    <div class="h-20 flex items-center">
                        <img src="{{ isset($companyInfo['logo']) ? asset('storage/' . $companyInfo['logo']) : asset('images/shankhobazar.png') }}" alt="Shankhobazar Logo" class="h-full w-auto object-contain">
                    </div>
                </div>
                <p class="text-gray-400 mb-6 leading-relaxed">
                    {{ $companyInfo['description'] ?? 'Your premium shopping destination for quality products. We bring you the best deals, authentic products, and exceptional customer service.' }}
                </p>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="text-white font-semibold text-lg mb-6">{{ $quickLinks['title'] ?? 'Quick Links' }}</h4>
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
                        <a href="{{ $link['url'] ?? '#' }}" class="hover:text-secondary transition duration-300 flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2"></i> {{ $link['name'] ?? '' }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            <!-- Customer Service -->
            <div>
                <h4 class="text-white font-semibold text-lg mb-6">{{ $customerService['title'] ?? 'Customer Service' }}</h4>
                <ul class="space-y-3">
                    @foreach($customerService['items'] ?? [] as $link)
                    <li>
                        <a href="{{ $link['url'] ?? '#' }}" class="hover:text-secondary transition duration-300 flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2"></i> {{ $link['name'] ?? '' }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            <!-- Policies -->
            <div>
                <h4 class="text-white font-semibold text-lg mb-6">{{ $policies['title'] ?? 'Policies' }}</h4>
                <ul class="space-y-3">
                    @foreach($policies['items'] ?? [] as $link)
                    <li>
                        <a href="{{ $link['url'] ?? '#' }}" class="hover:text-secondary transition duration-300 flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2"></i> {{ $link['name'] ?? '' }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h4 class="text-white font-semibold text-lg mb-6">{{ $contactInfo['title'] ?? 'Contact Info' }}</h4>
                <ul class="space-y-4">
                    <li class="flex items-start">
                        <i class="fas fa-map-marker-alt text-white mt-1 mr-3"></i>
                        <span class="text-sm">{{ $contactInfo['address'] ?? '123 Shopping Street, Dhaka 1200, Bangladesh' }}</span>
                    </li>
                </ul>
                
                <!-- Social Media Icons -->
                <div class="flex space-x-3 mt-6">
                    @foreach($companyInfo['items'] ?? [] as $social)
                    <a href="{{ $social['url'] ?? '#' }}" class="w-8 h-8 bg-gray-800 rounded-full flex items-center justify-center hover:bg-primary transition duration-300 text-sm" title="{{ $social['name'] ?? '' }}">
                        <i class="{{ $social['icon'] ?? 'fab fa-facebook-f' }}"></i>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Newsletter Section Removed -->
    </div>

    <!-- Bottom Footer -->
    <div class="bg-gray-950 py-6">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <p class="text-center md:text-left text-gray-400 text-sm mb-4 md:mb-0">
                    &copy; {{ $bottomFooter['copyright_text'] ?? date('Y') . ' Shankhobazar. All rights reserved.' }}
                </p>
                <p class="text-center md:text-right text-gray-400 text-sm">
                    {{ $bottomFooter['credit_text'] ?? 'Designed and developed by' }} <a href="{{ $bottomFooter['developer_url'] ?? 'https://alphainno.com' }}" target="_blank" class="text-primary hover:text-white transition font-medium">{{ $bottomFooter['developer_name'] ?? 'Alphainno' }}</a>
                </p>
            </div>
        </div>
    </div>
</footer>
