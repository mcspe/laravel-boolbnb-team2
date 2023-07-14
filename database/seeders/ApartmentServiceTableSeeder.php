<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Apartment;
use App\Models\Service;


class ApartmentServiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      for($i=0; $i<50; $i++) {
        $apt = Apartment::inRandomOrder()->first();
        $service_id = Service::inRandomOrder()->first()->id;

        $apt->services()->attach($service_id);
      }
    }
}
