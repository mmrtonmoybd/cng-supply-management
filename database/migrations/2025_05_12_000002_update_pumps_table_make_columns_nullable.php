<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePumpsTableMakeColumnsNullable extends Migration
{
    public function up()
    {
        Schema::table('pumps', function (Blueprint $table) {
            $table->date('payment_date')->nullable()->change();
            $table->decimal('payment', 15, 2)->nullable()->change();
            $table->decimal('balance', 15, 2)->nullable()->change();
            $table->text('remarks')->nullable()->change();
        });
    }

    public function down() {}
}
