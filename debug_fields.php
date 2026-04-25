Y6<?php

use App\Models\CheckoutField;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$fields = CheckoutField::all();
foreach ($fields as $field) {
    echo "ID: {$field->id}, Name: '{$field->name}', Label: '{$field->label}'" . PHP_EOL;
}
