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
        Schema::table('dispansars', function (Blueprint $table) {
            $table->string('load_entry_id')->nullable()->change();
            $table->date('date')->nullable();
            $table->string('vehicle_reg_number')->nullable();
            $table->string('pump_name')->nullable();
            $table->decimal('cng_purchase_m3', 10, 2)->nullable();
            $table->decimal('lrate', 10, 2)->nullable();
            $table->decimal('purchase_taka', 15, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {}
};
