<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovieActorsTable extends Migration
{
    public function up()
    {
        Schema::create('movie_actors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('actor_id')->constrained('actors')->onDelete('cascade');
            $table->foreignId('movie_id')->constrained('movies')->onDelete('cascade');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('movie_actors');
    }
}
