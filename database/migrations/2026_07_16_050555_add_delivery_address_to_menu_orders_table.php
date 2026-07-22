<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('menu_orders', function (Blueprint $table) {
            $table->string('delivery_address')->nullable()->after('delivery_type');
            $table->decimal('latitude', 10, 7)->nullable()->after('delivery_address');
            $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
        });
    }

    public function down(): void
    {
        Schema::table('menu_orders', function (Blueprint $table) {
            $table->dropColumn(['delivery_address', 'latitude', 'longitude']);
        });
    }
};
