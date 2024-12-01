<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoviesTable extends Migration
{
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id(); // id
            $table->string('title'); // Title
            $table->year('release_year'); // Release_year
            $table->integer('duration'); // Duration
            $table->text('description'); // Description
            $table->string('photo'); // Photo (путь к изображению)
            $table->foreignId('studio_id')
                ->constrained('studios') // StudioID (ссылаемся на таблицу studios)
                ->onDelete('cascade'); // Удаление записи фильма при удалении студии
            $table->foreignId('age_rating_id')
                ->constrained('age_rating') // AgeRatingID (ссылаемся на таблицу age_rating)
                ->onDelete('cascade'); // Удаление записи фильма при удалении возрастного рейтинга
            $table->timestamps(); // Добавление полей created_at и updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('movies');
    }
}
