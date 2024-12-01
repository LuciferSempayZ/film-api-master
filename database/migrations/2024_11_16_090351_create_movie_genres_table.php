<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovieGenresTable extends Migration
{
    public function up()
    {
        Schema::create('movie_genres', function (Blueprint $table) {
            $table->foreignId('movie_id')->constrained('movies'); // MovieID
            $table->foreignId('genre_id')->constrained('genres'); // GenreID
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('movie_genres');
    }
}
