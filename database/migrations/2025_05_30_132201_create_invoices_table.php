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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('factory_type')->nullable();

            $table->unsignedBigInteger('factory_id')->nullable();
            $table->foreign('factory_id')
                ->references('id')
                ->on('factories')
                ->onDelete('cascade');
            
            $table->date('date')->nullable();
            $table->decimal('total', 15, 2)->nullable();
            $table->string('hash')->unique()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
