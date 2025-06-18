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
        Schema::table('transports', function (Blueprint $table) {
            $table->decimal('cash_receipt_amount', 15, 2)->nullable()->after('total_cost');
            $table->decimal('balance', 15, 2)->nullable()->after('total_cost');
            $table->text('recived_by')->nullable()->after('total_cost');
            $table->text('remarks')->nullable()->after('total_cost');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
    }
};
