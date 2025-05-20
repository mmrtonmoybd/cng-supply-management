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
        Schema::table('load_entries', function (Blueprint $table) {
            $table->dropColumn('pump_name');

            $table->unsignedBigInteger('pumpName_id')->nullable()->after('vehicle_reg_number');
            $table->foreign('pumpName_id')
                ->references('id')
                ->on('pump_names')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {}
};
