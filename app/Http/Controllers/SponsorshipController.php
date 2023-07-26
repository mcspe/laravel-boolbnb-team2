<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apartment;
use App\Models\Sponsorship;
use Illuminate\Support\Facades\Auth;


class SponsorshipController extends Controller
{
  public function index(Apartment $apartment) {

    if($apartment->user_id != Auth::id()) {
      return redirect()->route('admin.apartments.index')->with('not_authorized', "La pagina che stai tentando di visualizzare non esiste");
    }
    $sponsorships = Sponsorship::all();
    return view('admin.sponsorships.index', compact('sponsorships', 'apartment'));
  }
}
