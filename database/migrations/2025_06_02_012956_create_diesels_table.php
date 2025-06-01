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
        Schema::create('diesels', function (Blueprint $table) {
            $table->id();
            $table->date('d_date')->nullable();
            $table->time('d_time')->nullable();
            $table->string('slip_no')->nullable();
            $table->unsignedBigInteger('pumpName_id')->nullable();
            $table->foreign('pumpName_id')
                ->references('id')
                ->on('pump_names')
                ->onDelete('cascade');

            $table->unsignedBigInteger('vehicle_id')->nullable();
            $table->foreign('vehicle_id')
                ->references('id')
                ->on('vehicles')
                ->onDelete('cascade');
            $table->decimal('diesel_purchase_litre', 10, 2)->nullable();
            $table->decimal('taka', 10, 2)->nullable();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->decimal('distance', 10, 2)->nullable();
            $table->decimal('use_litre', 10, 2)->nullable();
            $table->decimal('use_balance', 10, 2)->nullable();
            $table->string('remark')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diesels');
    }
};
