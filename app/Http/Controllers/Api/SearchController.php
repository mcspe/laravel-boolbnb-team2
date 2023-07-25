<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Apartment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;


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

      $input = $data['input'];
      $radius = $data['radius']; // in Km
      $services = $data['services'];

      // URL Base
      $baseUrl = 'https://api.tomtom.com/search/2/search/';

      // Function for slug the address
      $addressToSearch = Str::slug($input, '%20');

      // Type of query which returns a json
      $query = '.json?typeahead=false&limit=1&view=Unified&key=';

      // Api key
      $apiKey = env("API_IT_KEY");

      // Receive contents in a json
      $addressJsonResults = file_get_contents($baseUrl . $addressToSearch . $query . $apiKey);

      // Decoding json
      $decodingAddress = json_decode($addressJsonResults, JSON_PRETTY_PRINT);

      // Get latitude and longitude from json array
      $latitude = $decodingAddress['results'][0]['position']['lat'];
      $longitude = $decodingAddress['results'][0]['position']['lon'];
      // $longitude = $data['longitude'];
      // $latitude = $data['latitude'];

      $apartments = Apartment::select([
          'id', 'user_id', 'title', 'slug', 'category', 'address', 'n_rooms', 'n_beds', 'n_bathrooms','square_meters', 'price', 'cover_image', 'is_visible',
          DB::raw("ST_X(latitude_longitude) as latitude"),
          DB::raw("ST_Y(latitude_longitude) as longitude"),
          DB::raw("ST_Distance_Sphere(point(ST_X(latitude_longitude), ST_Y(latitude_longitude)), point($latitude, $longitude)) / 1000 as distance")
        ])
        ->with('services', 'visits')
        ->having('distance', '<=', $radius)
        ->when(count($services) > 0, function ($query) use ($services) {
          return $query->whereHas('services', function (Builder $query) use ($services) {
              $query->whereIn('service_id', $services);
          }, '=', count($services));
        })
        ->orderBy('distance')
        ->get();

        return response()->json(compact('apartments'));
      }

    }


      // if (count($services) > 0) {
      //   $query->whereHas('services', function (Builder $query) use ($services) {
      //       $query->whereIn('service_id', $services);
      //   });
      // }




      // $filteredApartments = $apartments->filter(function ($apartment) use ($longitude, $latitude, $radius) {
      //     $distanceInKm = $this->calculateDistance($apartment->longitude, $apartment->latitude, $longitude, $latitude);
      //     return $distanceInKm <= $radius;
      // })->values()->toArray();





      // return response()->json(compact('filteredApartments'));

