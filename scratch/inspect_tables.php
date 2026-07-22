<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$rows = Illuminate\Support\Facades\DB::select("SELECT name, sql FROM sqlite_master WHERE type='table' AND name IN ('cake_orders', 'menu_orders')");

foreach ($rows as $row) {
    echo "=== TABLE: {$row->name} ===\n";
    echo $row->sql . "\n\n";
}

echo "=== MIGRATIONS ===\n";
var_dump(Illuminate\Support\Facades\DB::table('migrations')->pluck('migration')->toArray());

