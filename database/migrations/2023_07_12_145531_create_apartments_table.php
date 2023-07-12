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
            $table->string('category');
            $table->text('address');
            $table->tinyInteger('n_rooms')->unsigned();
            $table->tinyInteger('n_bathrooms')->unsigned();
            $table->tinyInteger('n_beds')->unsigned();
            $table->integer('square_meters')->unsigned();
            $table->point('latitude_longitude');
            $table->decimal('price', $precision = 6, $scale = 2);
            $table->text('cover_image');
            $table->boolean('is_visible')->default(0);
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
