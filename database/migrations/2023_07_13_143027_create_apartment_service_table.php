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
        Schema::create('apartment_service', function (Blueprint $table) {
            $table->unsignedBigInteger('apartment_id')->nullable();
	        $table->foreign('apartment_id')->references('id')->on('apartments')->onDelete('set null');

            $table->unsignedBigInteger('service_id')->nullable();
	        $table->foreign('service_id')->references('id')->on('services')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apartment_service');
    }
};
