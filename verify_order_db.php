<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\Order;

try {
    echo "Database: " . DB::connection()->getDatabaseName() . PHP_EOL;
    $tables = DB::connection()->select('SHOW TABLES');
    echo "Tables found: " . count($tables) . PHP_EOL;
    foreach ($tables as $table) {
        $array = (array) $table;
        echo reset($array) . PHP_EOL;
    }

    echo "Attempting to create a dummy order..." . PHP_EOL;
    DB::beginTransaction();
    $order = Order::create([
        'total_amount' => 100,
        'status' => 'pending',
        'checkout_details' => ['test' => 'data'],
        'payment_method' => 'cod'
    ]);
    echo "Order created with ID: " . $order->id . PHP_EOL;
    DB::rollBack();
    echo "Transaction rolled back (success)." . PHP_EOL;

} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . PHP_EOL;
}
