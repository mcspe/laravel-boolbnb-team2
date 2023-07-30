<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class DashboardController extends Controller
{
    public function index(){
       // I take the total number of posts (single user)
        $n_apartments = Apartment::where("user_id", Auth::id())->count();
        $n_messages = Message::join('apartments', 'messages.apartment_id', '=', 'apartments.id')
          ->join('users', 'apartments.user_id', '=', 'users.id')
          ->where('users.id', Auth::id())
          ->count();
        $mostWanted = Apartment::select('apartments.*')
                      ->join('visits', 'apartments.id', '=', 'visits.apartment_id')
                      ->where('apartments.user_id', Auth::id())
                      ->groupBy('apartments.id')
                      ->orderByRaw('COUNT(visits.apartment_id) DESC')
                      ->first();

        return view("admin.home", compact("n_apartments", 'n_messages', 'mostWanted'));
    }
}
