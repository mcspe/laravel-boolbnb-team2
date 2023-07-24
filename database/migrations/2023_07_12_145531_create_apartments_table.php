<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category')->nullable();
            $table->text('address');
            $table->tinyInteger('n_rooms')->unsigned()->nullable();
            $table->tinyInteger('n_bathrooms')->unsigned()->nullable();
            $table->tinyInteger('n_beds')->unsigned()->nullable();
            $table->integer('square_meters')->unsigned()->nullable();
            $table->point('latitude_longitude')->nullable();
            $table->decimal('price', $precision = 6, $scale = 2)->nullable();
            $table->text('cover_image')->nullable();
            $table->boolean('is_visible')->nullable();
            $table->timestamp('deleted_at')->nullable();
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
        Schema::dropIfExists('apartments');
    }
};
