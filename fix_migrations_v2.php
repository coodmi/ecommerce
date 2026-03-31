<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$deleted = DB::table('migrations')
    ->where('migration', 'like', '%create_orders_table')
    ->orWhere('migration', 'like', '%create_order_items_table')
    ->delete();

echo "Deleted $deleted migration entries." . PHP_EOL;
