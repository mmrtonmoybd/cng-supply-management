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
        Schema::create('cng_pumps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('load_entry_id')->nullable();
            $table->foreign('load_entry_id')->references('id')->on('load_entries')->onDelete('cascade');
            $table->date('date')->nullable();
            $table->string('vehicle_reg_number')->nullable();
            $table->unsignedBigInteger('pumpName_id')->nullable();
            $table->foreign('pumpName_id')
                ->references('id')
                ->on('pump_names')
                ->onDelete('cascade');
            $table->unsignedBigInteger('factory_id')->nullable();
            $table->foreign('factory_id')
                ->references('id')
                ->on('factories')
                ->onDelete('cascade');
            $table->decimal('cng_purchase_m3', 10, 2)->nullable();
            $table->decimal('lrate', 10, 2)->nullable();
            $table->decimal('purchase_taka', 15, 2)->nullable();

            $table->integer('bill_no')->nullable();
            $table->date('bill_date')->nullable();
            $table->decimal('fm3', 15, 2)->nullable();
            $table->decimal('rate', 15, 2)->nullable();
            $table->decimal('ftk', 15, 2)->nullable();
            $table->decimal('difference_taka', 15, 2)->nullable();
            $table->decimal('difference_m3', 15, 2)->nullable();
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
        Schema::dropIfExists('cng_pumps');
    }
};
