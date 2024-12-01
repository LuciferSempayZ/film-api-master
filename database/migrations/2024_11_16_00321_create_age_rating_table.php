<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgeRatingTable extends Migration
{
    public function up()
    {
        Schema::create('age_rating', function (Blueprint $table) {
            $table->id(); // id
            $table->tinyInteger('age'); // Age
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('age_rating');
    }
}
