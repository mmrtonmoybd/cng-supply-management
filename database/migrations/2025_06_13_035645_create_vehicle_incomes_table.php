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
        Schema::create('vehicle_incomes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('load_entry_id')->nullable();
            $table->foreign('load_entry_id')->references('id')->on('load_entries')->onDelete('cascade');
            $table->unsignedBigInteger('dispansar_id')->nullable();
            $table->foreign('dispansar_id')
                ->references('id')
                ->on('dispansars')
                ->onDelete('cascade');

            $table->unsignedBigInteger('weight_one_id')->nullable();
            $table->foreign('weight_one_id')
                ->references('id')
                ->on('weight_ones')
                ->onDelete('cascade');

            $table->unsignedBigInteger('weight_id')->nullable();
            $table->foreign('weight_id')
                ->references('id')
                ->on('weights')
                ->onDelete('cascade');

            $table->unsignedBigInteger('cng_pump_id')->nullable();
            $table->foreign('cng_pump_id')
                ->references('id')
                ->on('cng_pumps')
                ->onDelete('cascade');

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
            $table->date('bill_date')->nullable();
            $table->decimal('fm3', 15, 2)->nullable();
            $table->decimal('rate', 15, 2)->nullable();
            $table->decimal('ftk', 15, 2)->nullable();
            $table->decimal('difference', 15, 2)->nullable();
            $table->decimal('rent', 15, 2)->nullable();
            $table->decimal('driver_fooding', 15, 2)->nullable();
            $table->decimal('maintenance', 15, 2)->nullable();
            $table->decimal('other', 15, 2)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_incomes');
    }
};
