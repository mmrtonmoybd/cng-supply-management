<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePumsTable extends Migration
{
    public function up()
    {
        Schema::create('pumps', function (Blueprint $table) {
            $table->id();
            $table->date('payment_date');
            $table->decimal('payment', 15, 2);
            $table->decimal('balance', 15, 2);
            $table->text('remarks')->nullable();
            $table->foreignId('load_entry_id')->constrained('load_entries')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pumps');
    }
}
