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
        $apartment = Apartment::whereDoesntHave('sponsorships', function ($query) {
          $query->where('expiration_date', '>=', Carbon::now());
        })->inRandomOrder()->first();

        if (!$apartment) {
          continue; // Skip if all apartments already have active sponsorships
        }

        $sponsorship = Sponsorship::inRandomOrder()->first();

        $aptSponsor = new ApartmentSponsorship();
        $aptSponsor->apartment_id = $apartment->id;
        $aptSponsor->sponsorship_id = $sponsorship->id;
        $aptSponsor->payment_date = $faker->dateTimeBetween('-3 days', 'now');

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

