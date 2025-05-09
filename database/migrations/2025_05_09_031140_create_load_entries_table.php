<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('load_entries', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('vehicle_reg_number');
            $table->string('pump_name');
            $table->decimal('cng_purchase_m3', 10, 2);
            $table->decimal('rate', 10, 2);
            $table->decimal('purchase_taka', 15, 2);
            $table->decimal('fuel_cost', 15, 2)->nullable();
            $table->string('fuel_pump')->nullable();
            $table->decimal('diesel_litter', 15, 2)->nullable();
            $table->decimal('diesel_rate', 15, 2)->nullable();
            $table->string('factory_name')->nullable();
            $table->enum('status', [
                'use',
                'not_use',
            ]); // 0 = pending, 1 = approved, 2 = rejected
            $table->mediumText('remark')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('load_entries');
    }
};
