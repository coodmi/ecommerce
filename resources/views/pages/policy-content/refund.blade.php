<div class="prose prose-gray max-w-none">
    <div class="flex items-center gap-3 mb-8 pb-6 border-b border-gray-100">
        <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0">
            <i class="fas fa-undo-alt text-xl" style="color: var(--primary-color)"></i>
        </div>
        <div>
            <h2 class="text-xl font-bold text-gray-900 m-0">Refund Policy</h2>
            <p class="text-gray-500 text-sm m-0">We want you to be completely satisfied with your purchase.</p>
        </div>
    </div>

    <!-- Quick Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        @foreach([
            ['icon' => 'fa-calendar-check', 'title' => '7-Day Returns', 'desc' => 'Return within 7 days of delivery'],
            ['icon' => 'fa-box-open', 'title' => 'Original Condition', 'desc' => 'Items must be unused & in original packaging'],
            ['icon' => 'fa-money-bill-wave', 'title' => 'Full Refund', 'desc' => 'Get 100% refund on eligible returns'],
        ] as $card)
        <div class="bg-gray-50 rounded-xl p-4 text-center border border-gray-100">
            <div class="w-10 h-10 rounded-full mx-auto mb-2 flex items-center justify-center" style="background: var(--primary-color)">
                <i class="fas {{ $card['icon'] }} text-white text-sm"></i>
            </div>
            <p class="font-semibold text-gray-900 text-sm">{{ $card['title'] }}</p>
            <p class="text-gray-500 text-xs mt-1">{{ $card['desc'] }}</p>
        </div>
        @endforeach
    </div>

    <div class="space-y-8">
        <div>
            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2 mb-3">
                <span class="w-7 h-7 rounded-full bg-primary text-white text-xs flex items-center justify-center flex-shrink-0">1</span>
                Return Eligibility
            </h3>
            <p class="text-gray-600 leading-relaxed mb-3">To be eligible for a return, your item must meet the following conditions:</p>
            <ul class="text-gray-600 space-y-2 list-none pl-0">
                @foreach(['Item must be returned within 7 days of delivery', 'Item must be unused and in the same condition as received', 'Item must be in the original packaging with all tags attached', 'Proof of purchase (order number or receipt) is required', 'Perishable goods, intimate items, and digital products are non-returnable'] as $item)
                <li class="flex items-start gap-2"><i class="fas fa-check-circle mt-1 flex-shrink-0" style="color: var(--primary-color)"></i> {{ $item }}</li>
                @endforeach
            </ul>
        </div>

        <div>
            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2 mb-3">
                <span class="w-7 h-7 rounded-full bg-primary text-white text-xs flex items-center justify-center flex-shrink-0">2</span>
                How to Initiate a Return
            </h3>
            <div class="space-y-3">
                @foreach([
                    ['step' => '01', 'text' => 'Contact our support team via the Contact page or email within 7 days of receiving your order.'],
                    ['step' => '02', 'text' => 'Provide your order number, the item(s) you wish to return, and the reason for the return.'],
                    ['step' => '03', 'text' => 'Our team will review your request and send you a return authorization within 24-48 hours.'],
                    ['step' => '04', 'text' => 'Pack the item securely and ship it to the address provided in the return authorization.'],
                ] as $s)
                <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg">
                    <span class="font-bold text-sm flex-shrink-0" style="color: var(--primary-color)">{{ $s['step'] }}</span>
                    <p class="text-gray-600 text-sm m-0">{{ $s['text'] }}</p>
                </div>
                @endforeach
            </div>
        </div>

        <div>
            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2 mb-3">
                <span class="w-7 h-7 rounded-full bg-primary text-white text-xs flex items-center justify-center flex-shrink-0">3</span>
                Refund Processing
            </h3>
            <p class="text-gray-600 leading-relaxed">Once we receive and inspect your returned item, we will notify you of the approval or rejection of your refund. If approved, your refund will be processed within <strong>5-7 business days</strong> to your original payment method.</p>
        </div>

        <div>
            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2 mb-3">
                <span class="w-7 h-7 rounded-full bg-primary text-white text-xs flex items-center justify-center flex-shrink-0">4</span>
                Damaged or Defective Items
            </h3>
            <p class="text-gray-600 leading-relaxed">If you receive a damaged or defective item, please contact us immediately with photos of the damage. We will arrange a replacement or full refund at no additional cost to you, including return shipping.</p>
        </div>

        <div>
            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2 mb-3">
                <span class="w-7 h-7 rounded-full bg-primary text-white text-xs flex items-center justify-center flex-shrink-0">5</span>
                Shipping Costs
            </h3>
            <p class="text-gray-600 leading-relaxed">Return shipping costs are the responsibility of the customer unless the item is defective or we made an error. Original shipping charges are non-refundable unless the return is due to our error.</p>
        </div>

        <div class="bg-primary/5 rounded-xl p-5 border border-primary/20">
            <h3 class="text-base font-semibold text-gray-900 mb-2 flex items-center gap-2">
                <i class="fas fa-headset" style="color: var(--primary-color)"></i> Need Help?
            </h3>
            <p class="text-gray-600 text-sm m-0">If you have any questions about our refund policy, please <a href="/contact" class="font-medium hover:underline" style="color: var(--primary-color)">contact our support team</a>. We're here to help.</p>
        </div>
    </div>
</div>
