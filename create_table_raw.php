<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

echo "Current Database: " . DB::connection()->getDatabaseName() . PHP_EOL;

if (!Schema::hasTable('orders')) {
    echo "Creating orders table manually..." . PHP_EOL;
    try {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->decimal('total_amount', 10, 2);
            $table->string('status')->default('pending');
            $table->text('checkout_details')->nullable();
            $table->string('payment_method')->nullable();
            $table->timestamps();
        });
        echo "Orders table created." . PHP_EOL;
    } catch (\Exception $e) {
        echo "Error creating orders: " . $e->getMessage() . PHP_EOL;
    }
} else {
    echo "Orders table ALREADY EXISTS." . PHP_EOL;
}

if (!Schema::hasTable('order_items')) {
    echo "Creating order_items table manually..." . PHP_EOL;
    try {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->integer('quantity');
            $table->decimal('price', 10, 2);
            $table->timestamps();
        });
        echo "Order_items table created." . PHP_EOL;
    } catch (\Exception $e) {
        echo "Error creating order_items: " . $e->getMessage() . PHP_EOL;
    }
} else {
    echo "Order_items table ALREADY EXISTS." . PHP_EOL;
}
