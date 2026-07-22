<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cake_orders', function (Blueprint $table) {
            $table->string('email')->nullable()->change();
        });

        Schema::table('menu_orders', function (Blueprint $table) {
            $table->string('email')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('cake_orders', function (Blueprint $table) {
            $table->string('email')->nullable(false)->change();
        });

        Schema::table('menu_orders', function (Blueprint $table) {
            $table->string('email')->nullable(false)->change();
        });
    }
};
