<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

echo "Current Database: " . DB::getDatabaseName() . PHP_EOL;

try {
    echo "Creating table checkout_fields..." . PHP_EOL;
    DB::statement("CREATE TABLE IF NOT EXISTS checkout_fields (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        label VARCHAR(255) NOT NULL,
        name VARCHAR(255) NOT NULL,
        type VARCHAR(255) DEFAULT 'text',
        placeholder VARCHAR(255) NULL,
        options TEXT NULL,
        is_required TINYINT(1) DEFAULT 1,
        sort_order INT DEFAULT 0,
        is_active TINYINT(1) DEFAULT 1,
        created_at TIMESTAMP NULL,
        updated_at TIMESTAMP NULL
    )");
    echo "Table created successfully." . PHP_EOL;
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}

echo "Checking if table exists via Schema..." . PHP_EOL;
var_dump(Schema::hasTable('checkout_fields'));

echo "Listing tables in " . DB::getDatabaseName() . ":" . PHP_EOL;
$tables = DB::select('SHOW TABLES');
foreach ($tables as $table) {
    print_r($table);
}
