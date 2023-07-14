<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\Apartment;
use App\Models\Sponsorship;
use App\Models\ApartmentSponsorship;
use DateTime;
use DateInterval;

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
        $aptSponsor->payment_date = date('Y-m-d H:i:s');
        $expiration = $faker->dateTime();
        switch ($aptSponsor->sponsorship_id) {
          case '1':
            $expiration->add(new DateInterval("PT24H"));
            break;
          case '2':
            $expiration->add(new DateInterval("PT72H"));
            break;
          case '3':
            $expiration->add(new DateInterval("PT144H"));
            break;
        }
        $aptSponsor->expiration_date = $expiration->format('Y-m-d H:i:s');
        $aptSponsor->save();
      }

    }
}

