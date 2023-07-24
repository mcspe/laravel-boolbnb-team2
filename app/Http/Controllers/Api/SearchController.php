<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Apartment;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    ////////////////////////////////////////////
  private function calculateDistance($longitude1, $latitude1, $longitude2, $latitude2) {

    $rawDistance = DB::selectOne("SELECT ST_Distance_Sphere(point($longitude1, $latitude1), point($longitude2, $latitude2)) as distance");

    return $rawDistance->distance / 1000;
}
  ///////////////////////////////////////////
  public function advancedSearch(Request $request) {

      $data = $request->all();

      // $longitude = 14.198047;
      // $latitude = 40.803755;
      // $radius = 100; // in Km

      $longitude = $data['longitude'];
      $latitude = $data['latitude'];
      $radius = $data['radius']; // in Km

      $apartments = Apartment::select([
        'id', 'user_id', 'title', 'slug', 'category', 'address',
        'address', 'n_rooms', 'n_beds', 'n_of_bed', 'n_bathrooms', 'n_of_bathroom',
        'square_meters', 'price', 'cover_image', 'is_visible',
        DB::raw("ST_Y(coordinate) as latitude"),
        DB::raw("ST_X(coordinate) as longitude"),
        DB::raw("ST_Distance_Sphere(point(ST_X(latitude_longitude), ST_Y(latitude_longitude)), point($latitude, $longitude)) / 1000 as distance")
    ])
    ->with('services', 'sponsorships', 'messages', 'visits')
    ->having('distance', '<=', $radius)
    ->orderBy('distance');

    return response()->json(compact('apartments'));
  }

      // $filteredApartments = $apartments->filter(function ($apartment) use ($longitude, $latitude, $radius) {
      //     $distanceInKm = $this->calculateDistance($apartment->longitude, $apartment->latitude, $longitude, $latitude);
      //     return $distanceInKm <= $radius;
      // })->values()->toArray();


      // return response()->json(compact('filteredApartments'));

}
