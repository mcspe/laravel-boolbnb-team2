<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class DashboardController extends Controller
{
    public function index(){
       // I take the total number of posts (single user)
        $n_apartments = Apartment::where("user_id", Auth::id())->count();
        return view("admin.home", compact("n_apartments"));
    }
}
