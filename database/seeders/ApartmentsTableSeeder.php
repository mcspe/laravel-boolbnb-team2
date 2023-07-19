<?php

namespace Database\Seeders;

use App\Helpers\CustomHelper;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Apartment;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ApartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $apartments = config('apartments');

        foreach($apartments as $apartment) {
            $new_apartment = new Apartment();
            $new_apartment->user_id = User::inRandomOrder()->first()->id;
            $new_apartment->title = $apartment['title'];
            // $new_apartment->slug = $apartment['slug'];
            $new_apartment->slug = CustomHelper::generateUniqueSlug($apartment['title'], new Apartment());
            $new_apartment->category = $apartment['category'];
            $new_apartment->address = $apartment['address'];
            $new_apartment->n_rooms = $apartment['n_rooms'];
            $new_apartment->n_bathrooms = $apartment['n_bathrooms'];
            $new_apartment->n_beds = $apartment['n_beds'];
            $new_apartment->square_meters = $apartment['square_meters'];
            // $new_apartment->latitude_longitude = DB::raw($apartment['latitude_longitude']);
            $new_apartment->latitude_longitude = DB::raw($new_apartment->getCoordinates($apartment['address']));
            $new_apartment->price = $apartment['price'];
            $new_apartment->cover_image = $apartment['cover_image'];
            $new_apartment->is_visible = $apartment['is_visible'];
            $new_apartment->save();
            // dd($new_apartment);
        }
    }
}
