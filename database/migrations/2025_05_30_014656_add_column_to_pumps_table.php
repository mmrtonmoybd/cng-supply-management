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
        Schema::table('pumps', function (Blueprint $table) {

            $table->unsignedBigInteger('dispansar_id')->nullable()->after('load_entry_id');
            $table->foreign('dispansar_id')
                ->references('id')
                ->on('dispansars')
                ->onDelete('cascade');

            $table->unsignedBigInteger('weight_one_id')->nullable()->after('load_entry_id');
            $table->foreign('weight_one_id')
                ->references('id')
                ->on('weight_ones')
                ->onDelete('cascade');

            $table->unsignedBigInteger('weight_id')->nullable()->after('load_entry_id');
            $table->foreign('weight_id')
                ->references('id')
                ->on('weights')
                ->onDelete('cascade');

            $table->unsignedBigInteger('cng_pump_id')->nullable()->after('load_entry_id');
            $table->foreign('cng_pump_id')
                ->references('id')
                ->on('cng_pumps')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pumps', function (Blueprint $table) {
            //
        });
    }
};
