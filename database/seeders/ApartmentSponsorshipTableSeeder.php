<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\Apartment;
use App\Models\Sponsorship;
use App\Models\ApartmentSponsorship;
use Illuminate\Support\Carbon;


class ApartmentSponsorshipTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
      for($i=0; $i<20; $i++) {
        $aptSponsor = new ApartmentSponsorship();
        $aptSponsor->apartment_id = Apartment::inRandomOrder()->first()->id;
        $aptSponsor->sponsorship_id = Sponsorship::inRandomOrder()->first()->id;
        $aptSponsor->payment_date = $faker->dateTimeBetween('-3 weeks', 'now');
        $expiration = Carbon::createFromDate($aptSponsor->payment_date);
        switch ($aptSponsor->sponsorship_id) {
          case '1':
            $expiration->addHours(24);
            break;
          case '2':
            $expiration->addHours(72);
            break;
          case '3':
            $expiration->addHours(144);
            break;
        }
        $aptSponsor->expiration_date = $expiration->format('Y-m-d H:i:s');
        $aptSponsor->save();
      }

    }
}

