<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSerialsTable extends Migration
{
    public function up()
    {
        Schema::create('serials', function (Blueprint $table) {
            $table->id(); // id
            $table->foreignId('movies_id')->constrained('movies'); // MoviesID
            $table->integer('quantity'); // Quantity
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('serials');
    }
}
