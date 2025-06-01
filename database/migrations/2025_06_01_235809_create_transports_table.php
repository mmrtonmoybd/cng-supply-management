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
        Schema::create('transports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehicle_id')->nullable();
            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade');
            $table->date('date')->nullable();
            $table->string('from')->nullable();
            $table->string('to')->nullable();
            $table->decimal('rent', 10, 2)->nullable();
            $table->decimal('maintenance_cost', 10, 2)->nullable();
            $table->decimal('diesel_cost', 10, 2)->nullable();
            $table->decimal('toll_cost', 10, 2)->nullable();
            $table->decimal('labour_cost', 10, 2)->nullable();
            $table->decimal('chada_cost', 10, 2)->nullable();
            $table->decimal('fooding_cost', 10, 2)->nullable();
            $table->decimal('police_cost', 10, 2)->nullable();
            $table->decimal('parking_cost', 10, 2)->nullable();
            $table->decimal('other_cost', 10, 2)->nullable();
            $table->decimal('total_cost', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transports');
    }
};
