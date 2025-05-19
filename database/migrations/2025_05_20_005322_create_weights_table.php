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
        Schema::create('weights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('load_entry_id')->nullable();
            $table->foreign('load_entry_id')->references('id')->on('load_entries')->onDelete('cascade');
            $table->date('date')->nullable();
            $table->string('vehicle_reg_number')->nullable();
            $table->string('pump_name')->nullable();
            $table->decimal('cng_purchase_m3', 10, 2)->nullable();
            $table->decimal('lrate', 10, 2)->nullable();
            $table->decimal('purchase_taka', 15, 2)->nullable();

            $table->string('bill_no')->nullable();
            $table->date('bill_date')->nullable();
            $table->decimal('first_weight', 15, 2)->nullable();
            $table->decimal('second_weight', 15, 2)->nullable();
            $table->decimal('total_weight', 15, 2)->nullable();
            $table->decimal('fact', 15, 2)->nullable();
            $table->decimal('receive_m3', 15, 2)->nullable();
            $table->decimal('rate', 15, 2)->nullable();
            $table->decimal('ftk', 15, 2)->nullable();
            $table->string('total_bill_no')->nullable();
            $table->string('total_bill_taka')->nullable();
            $table->decimal('difference_taka', 15, 2)->nullable();
            $table->decimal('difference_m3', 15, 2)->nullable();
            $table->decimal('in', 15, 2)->nullable();
            $table->decimal('out', 15, 2)->nullable();
            $table->decimal('bill_amount', 15, 2)->nullable();
            $table->date('cash_receipt_date')->nullable();
            $table->decimal('cash_receipt_amount', 15, 2)->nullable();
            $table->decimal('balance', 15, 2)->nullable();
            $table->text('recived_by')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weights');
    }
};
