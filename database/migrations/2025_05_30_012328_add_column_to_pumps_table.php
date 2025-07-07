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
            $table->date('date')->nullable()->after('id');
            $table->string('vehicle_reg_number')->nullable()->after('id');
            $table->unsignedBigInteger('pumpName_id')->nullable()->after('id');
            $table->foreign('pumpName_id')
                ->references('id')
                ->on('pump_names')
                ->onDelete('cascade');
            $table->unsignedBigInteger('factory_id')->nullable()->after('id');
            $table->foreign('factory_id')
                ->references('id')
                ->on('factories')
                ->onDelete('cascade');
            $table->decimal('cng_purchase_m3', 10, 3)->nullable()->after('id');
            $table->decimal('rate', 10, 2)->nullable()->after('id');
            $table->decimal('purchase_taka', 15, 2)->nullable()->after('id');
            $table->foreignId('load_entry_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {}
};
