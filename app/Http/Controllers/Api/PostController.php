<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Apartment;
use Illuminate\Support\Facades\DB;

class PostController extends Controller {
  ///////////////////////////////////////////
  public function index(){
    //$apartments = Apartment::all();
    $apartments = Apartment::select(['id','user_id','title','slug','category','address','n_rooms','n_beds','n_bathrooms','square_meters',
    DB::raw('ST_X(latitude_longitude) as latitude'), DB::raw('ST_Y(latitude_longitude) as longitude'),'price','cover_image','is_visible'])->with('services','sponsorships','messages','visits')->get();
    return response()->json($apartments);
  }
  ////////////////////////////////////////////
  private function calculateDistance($longitude1, $latitude1, $longitude2, $latitude2) {
    $rawDistance = DB::selectOne("SELECT ST_Distance_Sphere(point($longitude1, $latitude1), point($longitude2, $latitude2)) as distance");
    return $rawDistance->distance / 1000;
}
  ///////////////////////////////////////////
  public function advancedSearch() { //aggiungere eventualmente la REQUEST tra le tonde della funzione
      // $data = $request->all();

      $apartments = Apartment::select([
          'id', 'user_id', 'title', 'slug', 'category', 'address', 'n_rooms', 'n_beds', 'n_bathrooms', 'square_meters',
          DB::raw('ST_X(latitude_longitude) as latitude'), DB::raw('ST_Y(latitude_longitude) as longitude'), 'price', 'cover_image', 'is_visible'
      ])
      ->with('services', 'sponsorships', 'messages', 'visits')
      ->get();

      // $longitude = $data['longitude'];
      // $latitude = $data['latitude'];
      // $radius = $data['radius']; // in Km

      $longitude = 14.198047;
      $latitude = 40.803755;
      $radius = 100; // in Km

      $filteredApartments = $apartments->filter(function ($apartment) use ($longitude, $latitude, $radius) {
          $distanceInKm = $this->calculateDistance($apartment->longitude, $apartment->latitude, $longitude, $latitude);
          return $distanceInKm <= $radius;
      })->values()->toArray();


      return response()->json(compact('filteredApartments'));
  }

}
