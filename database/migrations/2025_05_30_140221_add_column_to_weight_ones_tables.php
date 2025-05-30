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
        Schema::table('weight_ones', function (Blueprint $table) {
            $table->unsignedBigInteger('invoice_id')->nullable()->after('cash_receipt_amount');
            $table->foreign('invoice_id')
                ->references('id')
                ->on('invoices')
                ->onDelete('set null');

            $table->date('invoice_date')->nullable()->after('invoice_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {}
};
