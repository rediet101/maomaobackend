<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cake_orders', function (Blueprint $table) {
            $table->enum('delivery_type', ['driver', 'self_pickup'])->default('self_pickup')->after('pickup_delivery_date');
            $table->string('delivery_address')->nullable()->after('delivery_type');
        });
    }

    public function down(): void
    {
        Schema::table('cake_orders', function (Blueprint $table) {
            $table->dropColumn(['delivery_type', 'delivery_address']);
        });
    }
};
