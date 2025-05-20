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
            $table->dropColumn('factory_name');
            $table->unsignedBigInteger('factory_id')->nullable()->after('pumpName_id');
            $table->foreign('factory_id')
                ->references('id')
                ->on('factories')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {}
};
