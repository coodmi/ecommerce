<?php

use App\Models\CheckoutField;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$fields = CheckoutField::all();
foreach ($fields as $field) {
    echo "Name: '{$field->name}', Type: '{$field->type}'" . PHP_EOL;
}
