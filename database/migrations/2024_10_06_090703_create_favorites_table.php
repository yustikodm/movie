<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFavoritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->bigIncrements('id'); // Use bigIncrements instead of id()
            $table->unsignedBigInteger('user_id'); // Define the user_id as unsignedBigInteger
            $table->string('title');
            $table->string('year');
            $table->string('rated')->nullable();
            $table->string('released')->nullable();
            $table->string('runtime')->nullable();
            $table->string('genre');
            $table->string('director')->nullable();
            $table->string('writer')->nullable();
            $table->string('actors')->nullable();
            $table->text('plot')->nullable();
            $table->string('language')->nullable();
            $table->string('country')->nullable();
            $table->string('awards')->nullable();
            $table->string('poster')->nullable();
            $table->string('ratings')->nullable();
            $table->string('imdbRating')->nullable();
            $table->string('imdbVotes')->nullable();
            $table->string('imdbID')->unique();
            $table->string('type');
            $table->timestamps();

            // Define the foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('favorites');
    }
}
