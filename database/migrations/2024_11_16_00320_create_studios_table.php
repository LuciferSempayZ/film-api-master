<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudiosTable extends Migration
{
    public function up()
    {
        Schema::create('studios', function (Blueprint $table) {
            $table->id(); // id
            $table->string('name'); // Name
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('studios');
    }
}
