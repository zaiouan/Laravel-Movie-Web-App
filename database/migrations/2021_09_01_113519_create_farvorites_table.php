<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFarvoritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('farvorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movie_id')->nullable()->constrained('movies')->onDelete('cascade');
            $table->foreignId('serie_id')->nullable()->constrained('series')->onDelete('cascade');
            $table->foreignId('actor_id')->nullable()->constrained('actors')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->boolean('favorite');
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
        Schema::dropIfExists('farvorites');
    }
}
