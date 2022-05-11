<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActorMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actor_movies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movie_id')->nullable()->constrained('movies')->onDelete('cascade');
            $table->foreignId('serie_id')->nullable()->constrained('series')->onDelete('cascade');
            $table->foreignId('actor_id')->constrained('actors')->onDelete('cascade');
            $table->string('character');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('actor_movies');
    }
}
