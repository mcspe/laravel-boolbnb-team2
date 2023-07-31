<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\Visit;
use App\Models\Apartment;


class VisitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
      for($i=0; $i<2000; $i++) {
        $new_visit = new Visit();
        $new_visit->apartment_id = Apartment::inRandomOrder()->first()->id;
        $new_visit->ip_address = long2ip(mt_rand()+mt_rand()+mt_rand(0,1));
        $new_visit->visit_date = $faker->dateTimeBetween('-3 weeks', 'now')->format('Y-m-d H:i:s');
        $new_visit->save();
      }
    }
}
