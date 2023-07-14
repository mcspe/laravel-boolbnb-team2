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
        Schema::create('apartment_sponsorship', function (Blueprint $table) {

          $table->unsignedBigInteger('apartment_id')->nullable();
	        $table->foreign('apartment_id')->references('id')->on('apartments')->onDelete('set null');

          $table->unsignedBigInteger('sponsorship_id')->nullable();
	        $table->foreign('sponsorship_id')->references('id')->on('sponsorships')->onDelete('set null');

          $table->dateTime('payment_date');
          $table->dateTime('expiration_date');

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
        Schema::dropIfExists('apartment_sponsorship');
    }
};
