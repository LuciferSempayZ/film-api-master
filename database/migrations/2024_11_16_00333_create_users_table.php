<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // id
            $table->foreignId('roles_id')->constrained('roles'); // RolesID
            $table->string('username')->unique(); // Username
            $table->string('email')->unique(); // Email
            $table->string('password'); // Password
            $table->string('api_token', 100)->unique()->nullable(); // Api_token
            $table->string('avatar')->nullable(); // Avatar
            $table->string('gender')->nullable(); // Gender
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
