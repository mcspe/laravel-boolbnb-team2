<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Apartment;
use App\Models\Service;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class SearchController extends Controller{
    //////////////////////////////////////////// Controllare se viene utilizzata se no commentare
  // private function calculateDistance($longitude1, $latitude1, $longitude2, $latitude2) {

  //   $rawDistance = DB::selectOne("SELECT ST_Distance_Sphere(point($longitude1, $latitude1), point($longitude2, $latitude2)) as distance");

  //   return $rawDistance->distance / 1000;
  // }
  // ///////////////////////////////////////////
  public function advancedSearch(Request $request) {
    try {

      $data = $request->all();
      $input = $data['input'];
      $radius = $data['radius']; // in Km
      $services = $data['services'];
      $today = Carbon::now()->format('Y-m-d H:i:s');
      $availableServices = Service::all();

      if(!$input){
        $apartments = Apartment::select([
          'id', 'user_id', 'title', 'slug', 'category', 'address', 'n_rooms', 'n_beds', 'n_bathrooms','square_meters', 'price', 'cover_image', 'is_visible',
          DB::raw("ST_Y(latitude_longitude) as latitude"),
          DB::raw("ST_X(latitude_longitude) as longitude"),
          DB::raw("CASE WHEN apartment_sponsorship.apartment_id IS NOT NULL THEN 1 ELSE 0 END as sponsored"), 'apartment_sponsorship.expiration_date'
        ])
        ->where('is_visible', '=', 1)
        ->leftJoin('apartment_sponsorship', function ($join) use ($today) {
          $join->on('apartments.id', '=', 'apartment_sponsorship.apartment_id')
            ->where('apartment_sponsorship.expiration_date', '>=', $today);
        })
        ->with('services')
        ->when(count($services) > 0, function ($query) use ($services) {
          return $query->whereHas('services', function (Builder $query) use ($services) {
            $query->whereIn('service_id', $services);
          }, '=', count($services));
        })
        ->orderBy('apartment_sponsorship.expiration_date', 'desc')
        ->get();

        $count = count($apartments);

        return response()->json(compact('apartments', 'count', 'availableServices'));
      }else{
        // URL Base
        $baseUrl = 'https://api.tomtom.com/search/2/search/';

        // Function to slug the address
        $addressToSearch = Str::slug($input, '%20');

        // Type of query which returns a json
        $query = '.json?typeahead=false&limit=1&view=Unified&key=';

        // Api key
        $apiKey = env("API_IT_KEY");

        // Receive contents in a json
        $addressJsonResults = file_get_contents($baseUrl . $addressToSearch . $query . $apiKey);

        // Decoding json
        $decodingAddress = json_decode($addressJsonResults, JSON_PRETTY_PRINT);

        // if(isset($decodingAddress['summary']['numResults']) && $decodingAddress['summary']['numResults'] > 0) {
        //   $apartments = [];
        //   $count = 0;
        //   response()->json()->compact('apartments', 'count', 'availableServices');
        // }

        // Get latitude and longitude from json array
        $latitude = $decodingAddress['results'][0]['position']['lat'];
        $longitude = $decodingAddress['results'][0]['position']['lon'];
        // $longitude = $data['longitude'];
        // $latitude = $data['latitude'];

        $apartments = Apartment::select([
            'id', 'user_id', 'title', 'slug', 'category', 'address', 'n_rooms', 'n_beds', 'n_bathrooms','square_meters', 'price', 'cover_image', 'is_visible',
            DB::raw("ST_Y(latitude_longitude) as latitude"),
            DB::raw("ST_X(latitude_longitude) as longitude"),
            DB::raw("ST_Distance_Sphere(point(ST_X(latitude_longitude), ST_Y(latitude_longitude)), point($longitude, $latitude)) / 1000 as distance"),
            DB::raw("CASE WHEN apartment_sponsorship.apartment_id IS NOT NULL THEN 1 ELSE 0 END as sponsored"), 'apartment_sponsorship.expiration_date'
          ])
          ->where('is_visible', '=', 1)
          ->leftJoin('apartment_sponsorship', function ($join) use ($today) {
            $join->on('apartments.id', '=', 'apartment_sponsorship.apartment_id')
              ->where('apartment_sponsorship.expiration_date', '>=', $today);
          })
          ->with('services')
          ->having('distance', '<=', $radius)
          ->when(count($services) > 0, function ($query) use ($services) {
            return $query->whereHas('services', function (Builder $query) use ($services) {
                $query->whereIn('service_id', $services);
            }, '=', count($services));
          })
          ->orderBy('distance')
          ->orderBy('apartment_sponsorship.expiration_date', 'desc')
          ->get();

        $count = count($apartments);

        return response()->json(compact('apartments', 'count', 'availableServices'));

      }

    } catch (\Throwable $th) {
      if ($decodingAddress['summary']['numResults'] === 0) {
        $apartments = [];
        $count = 0;
        $availableServices = Service::all();

        return response()->json(compact('apartments', 'count', 'availableServices'));
      }
      return response()->json(['error' => $th->getMessage()], 500);
    }
  }
}
