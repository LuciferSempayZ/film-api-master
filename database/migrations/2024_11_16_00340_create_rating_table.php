<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingTable extends Migration
{
    public function up()
    {
        Schema::create('rating', function (Blueprint $table) {
            $table->id(); // id
            $table->foreignId('movies_id')->constrained('movies'); // MoviesID
            $table->foreignId('users_id')->constrained('users'); // UsersID
            $table->text('review_text'); // ReviewText
            $table->decimal('rating', 2, 1); // Rating
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rating');
    }
}
