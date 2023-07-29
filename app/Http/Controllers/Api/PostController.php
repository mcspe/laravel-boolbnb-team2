<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Apartment;
use App\Models\Service;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;


class PostController extends Controller {
  ///////////////////////////////////////////
  public function index(){
    //$apartments = Apartment::all();

    // query per prendere tutti gli appartamenti
    $apartments = Apartment::select([
      'id','user_id','title','slug','category','address','n_rooms','n_beds','n_bathrooms','square_meters',
      DB::raw('ST_Y(latitude_longitude) as latitude'),
      DB::raw('ST_X(latitude_longitude) as longitude'),
      'price','cover_image','is_visible'])
      ->where('is_visible', '=', 1)
      ->with('services','visits', 'user')->get();

    // query per prendere solo appartamenti sponsorizzati

    $sponsoredApt = Apartment::select([
      'id','user_id','title','slug','category','address','n_rooms','n_beds','n_bathrooms','square_meters', DB::raw('ST_Y(latitude_longitude) as latitude'), DB::raw('ST_X(latitude_longitude) as longitude'),'price','cover_image','is_visible'
      ])
      ->where('is_visible', '=', 1)
      ->with('services','visits')
      ->whereHas('sponsorships', function($q){
      // $today = '2023-07-18 11:06:00';
      $today = Carbon::now()->format('Y-m-d H:i:s');
      $q->where('expiration_date', '>=', $today);
    })->get();

    $availableServices = Service::all();

    $results = [
      'sponsored_apartments' => $sponsoredApt,
      'total_apartments' => $apartments,
      "availableServices" => $availableServices
    ];

    return response()->json($results);
  }

  public function getKey() {
    return response()->json(env('API_IT_KEY'));
  }
}
