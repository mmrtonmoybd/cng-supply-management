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
        Schema::table('diesels', function (Blueprint $table) {
            // Drop foreign key constraint (if exists)
            $table->dropForeign(['vehicle_id']);

            // Drop the column
            $table->dropColumn('vehicle_id');

            // Add the new string column
            $table->string('vehicle_reg_number')->nullable()->after('pumpName_id'); // adjust nullable as needed
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
