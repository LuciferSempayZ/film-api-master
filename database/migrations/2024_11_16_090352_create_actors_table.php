<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActorsTable extends Migration
{
    public function up()
    {
        Schema::create('actors', function (Blueprint $table) {
            $table->id(); // id
            $table->string('first_name'); // FirstName
            $table->string('last_name'); // LastName
            $table->date('birth_date'); // BirthDate
            $table->text('biography'); // Biography
            $table->string('photo'); // Photo
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('actors');
    }
}
