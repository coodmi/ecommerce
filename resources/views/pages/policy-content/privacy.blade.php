<div class="prose prose-gray max-w-none">
    <div class="flex items-center gap-3 mb-8 pb-6 border-b border-gray-100">
        <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0">
            <i class="fas fa-shield-alt text-xl" style="color: var(--primary-color)"></i>
        </div>
        <div>
            <h2 class="text-xl font-bold text-gray-900 m-0">Your Privacy Matters</h2>
            <p class="text-gray-500 text-sm m-0">We are committed to protecting your personal information.</p>
        </div>
    </div>

    <div class="space-y-8">
        <div>
            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2 mb-3">
                <span class="w-7 h-7 rounded-full bg-primary text-white text-xs flex items-center justify-center flex-shrink-0">1</span>
                Information We Collect
            </h3>
            <p class="text-gray-600 leading-relaxed">We collect information you provide directly to us, such as when you create an account, place an order, or contact us for support. This includes your name, email address, shipping address, phone number, and payment information.</p>
        </div>

        <div>
            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2 mb-3">
                <span class="w-7 h-7 rounded-full bg-primary text-white text-xs flex items-center justify-center flex-shrink-0">2</span>
                How We Use Your Information
            </h3>
            <ul class="text-gray-600 space-y-2 list-none pl-0">
                @foreach(['Process and fulfill your orders', 'Send order confirmations and shipping updates', 'Respond to your comments and questions', 'Send promotional communications (with your consent)', 'Improve our website and services', 'Comply with legal obligations'] as $item)
                <li class="flex items-start gap-2"><i class="fas fa-check-circle mt-1 flex-shrink-0" style="color: var(--primary-color)"></i> {{ $item }}</li>
                @endforeach
            </ul>
        </div>

        <div>
            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2 mb-3">
                <span class="w-7 h-7 rounded-full bg-primary text-white text-xs flex items-center justify-center flex-shrink-0">3</span>
                Information Sharing
            </h3>
            <p class="text-gray-600 leading-relaxed">We do not sell, trade, or rent your personal information to third parties. We may share your information with trusted service providers who assist us in operating our website and conducting our business, subject to confidentiality agreements.</p>
        </div>

        <div>
            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2 mb-3">
                <span class="w-7 h-7 rounded-full bg-primary text-white text-xs flex items-center justify-center flex-shrink-0">4</span>
                Data Security
            </h3>
            <p class="text-gray-600 leading-relaxed">We implement appropriate technical and organizational measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction. All payment transactions are encrypted using SSL technology.</p>
        </div>

        <div>
            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2 mb-3">
                <span class="w-7 h-7 rounded-full bg-primary text-white text-xs flex items-center justify-center flex-shrink-0">5</span>
                Your Rights
            </h3>
            <p class="text-gray-600 leading-relaxed">You have the right to access, correct, or delete your personal information at any time. You may also opt out of receiving promotional emails by clicking the unsubscribe link in any email we send.</p>
        </div>

        <div>
            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2 mb-3">
                <span class="w-7 h-7 rounded-full bg-primary text-white text-xs flex items-center justify-center flex-shrink-0">6</span>
                Contact Us
            </h3>
            <p class="text-gray-600 leading-relaxed">If you have any questions about this Privacy Policy, please contact us at <a href="/contact" class="font-medium hover:underline" style="color: var(--primary-color)">our contact page</a>.</p>
        </div>
    </div>
</div>
