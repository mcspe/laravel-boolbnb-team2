<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Apartment;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
  public function index(){
    //$apartments = Apartment::all();
    $apartments = Apartment::select(['id','user_id','title','slug','category','address','n_rooms','n_beds','n_bathrooms','square_meters',
    DB::raw('ST_X(latitude_longitude) as latitude'), DB::raw('ST_Y(latitude_longitude) as longitude'),'price','cover_image','is_visible'])->with('services','sponsorships','messages','visits')->get();
    return response()->json($apartments);
}
}
