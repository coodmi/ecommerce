<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "Database Name: " . DB::getDatabaseName() . PHP_EOL;

$tables = DB::select('SHOW TABLES');
echo "Tables found: " . count($tables) . PHP_EOL;
$tableNames = array_map(function($t) { return array_values((array)$t)[0]; }, $tables);
// print_r($tableNames);

if (in_array('orders', $tableNames)) {
    echo "SUCCESS: 'orders' table exists." . PHP_EOL;
} else {
    echo "ERROR: 'orders' table DOES NOT exist." . PHP_EOL;
}

if (in_array('order_items', $tableNames)) {
    echo "SUCCESS: 'order_items' table exists." . PHP_EOL;
} else {
    echo "ERROR: 'order_items' table DOES NOT exist." . PHP_EOL;
}

$migration = DB::table('migrations')->where('migration', 'like', '%create_orders_table')->first();
if ($migration) {
    echo "Migration entry found: " . $migration->migration . " (Batch: " . $migration->batch . ")" . PHP_EOL;
} else {
    echo "Migration entry NOT found for create_orders_table." . PHP_EOL;
}

$migrationItems = DB::table('migrations')->where('migration', 'like', '%create_order_items_table')->first();
if ($migrationItems) {
    echo "Migration entry found: " . $migrationItems->migration . " (Batch: " . $migrationItems->batch . ")" . PHP_EOL;
} else {
    echo "Migration entry NOT found for create_order_items_table." . PHP_EOL;
}
