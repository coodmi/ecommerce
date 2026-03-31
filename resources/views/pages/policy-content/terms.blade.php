<div class="prose prose-gray max-w-none">
    <div class="flex items-center gap-3 mb-8 pb-6 border-b border-gray-100">
        <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0">
            <i class="fas fa-file-contract text-xl" style="color: var(--primary-color)"></i>
        </div>
        <div>
            <h2 class="text-xl font-bold text-gray-900 m-0">Terms & Conditions</h2>
            <p class="text-gray-500 text-sm m-0">Please read these terms carefully before using our services.</p>
        </div>
    </div>

    <div class="space-y-8">
        <div>
            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2 mb-3">
                <span class="w-7 h-7 rounded-full bg-primary text-white text-xs flex items-center justify-center flex-shrink-0">1</span>
                Acceptance of Terms
            </h3>
            <p class="text-gray-600 leading-relaxed">By accessing and using Shankhobazar, you accept and agree to be bound by these Terms and Conditions. If you do not agree to these terms, please do not use our website or services.</p>
        </div>

        <div>
            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2 mb-3">
                <span class="w-7 h-7 rounded-full bg-primary text-white text-xs flex items-center justify-center flex-shrink-0">2</span>
                Use of the Website
            </h3>
            <ul class="text-gray-600 space-y-2 list-none pl-0">
                @foreach(['You must be at least 18 years old to make purchases', 'You are responsible for maintaining the confidentiality of your account', 'You agree not to use the site for any unlawful purpose', 'You must not attempt to gain unauthorized access to any part of the website', 'We reserve the right to refuse service to anyone at any time'] as $item)
                <li class="flex items-start gap-2"><i class="fas fa-check-circle mt-1 flex-shrink-0" style="color: var(--primary-color)"></i> {{ $item }}</li>
                @endforeach
            </ul>
        </div>

        <div>
            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2 mb-3">
                <span class="w-7 h-7 rounded-full bg-primary text-white text-xs flex items-center justify-center flex-shrink-0">3</span>
                Products & Pricing
            </h3>
            <p class="text-gray-600 leading-relaxed">All prices are displayed in the local currency and are subject to change without notice. We reserve the right to modify or discontinue any product at any time. We are not liable to you or any third party for any modification, suspension, or discontinuation of products.</p>
        </div>

        <div>
            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2 mb-3">
                <span class="w-7 h-7 rounded-full bg-primary text-white text-xs flex items-center justify-center flex-shrink-0">4</span>
                Orders & Payment
            </h3>
            <p class="text-gray-600 leading-relaxed">By placing an order, you are making an offer to purchase the product(s). We reserve the right to accept or decline your order. Payment must be received in full before orders are processed and shipped. We accept various payment methods as displayed at checkout.</p>
        </div>

        <div>
            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2 mb-3">
                <span class="w-7 h-7 rounded-full bg-primary text-white text-xs flex items-center justify-center flex-shrink-0">5</span>
                Intellectual Property
            </h3>
            <p class="text-gray-600 leading-relaxed">All content on this website, including text, graphics, logos, images, and software, is the property of Shankhobazar and is protected by applicable intellectual property laws. You may not reproduce, distribute, or create derivative works without our express written permission.</p>
        </div>

        <div>
            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2 mb-3">
                <span class="w-7 h-7 rounded-full bg-primary text-white text-xs flex items-center justify-center flex-shrink-0">6</span>
                Limitation of Liability
            </h3>
            <p class="text-gray-600 leading-relaxed">Shankhobazar shall not be liable for any indirect, incidental, special, or consequential damages arising from your use of our website or products. Our total liability shall not exceed the amount paid for the specific product giving rise to the claim.</p>
        </div>

        <div>
            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2 mb-3">
                <span class="w-7 h-7 rounded-full bg-primary text-white text-xs flex items-center justify-center flex-shrink-0">7</span>
                Changes to Terms
            </h3>
            <p class="text-gray-600 leading-relaxed">We reserve the right to update these Terms and Conditions at any time. Changes will be effective immediately upon posting to the website. Your continued use of the website after any changes constitutes your acceptance of the new terms.</p>
        </div>
    </div>
</div>
