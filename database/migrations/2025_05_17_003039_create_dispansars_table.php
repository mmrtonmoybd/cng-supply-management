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
        Schema::create('dispansars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('load_entry_id')->constrained('load_entries')->onDelete('cascade');
            $table->integer('bill_no')->nullable();
            $table->date('bill_date')->nullable();
            $table->decimal('opening_reading', 15, 2)->nullable();
            $table->decimal('closing_reading', 15, 2)->nullable();
            $table->decimal('total_reading', 15, 2)->nullable();
            $table->decimal('rate', 15, 2)->nullable();
            $table->decimal('bill_amount', 15, 2)->nullable();
            $table->decimal('difference_m3', 15, 2)->nullable();
            $table->decimal('difference_taka', 15, 2)->nullable();
            $table->decimal('in', 15, 2)->nullable();
            $table->decimal('out', 15, 2)->nullable();
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
        Schema::dropIfExists('dispansars');
    }
};
