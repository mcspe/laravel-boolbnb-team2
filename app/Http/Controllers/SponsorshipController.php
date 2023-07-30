<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apartment;
use App\Models\Sponsorship;
use App\Models\ApartmentSponsorship;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;


class SponsorshipController extends Controller
{
  public function index(Apartment $apartment) {

    if($apartment->user_id != Auth::id()) {
      return redirect()->route('admin.apartments.index')->with('not_authorized', "La pagina che stai tentando di visualizzare non esiste");
    }
    $today = Carbon::now()->format('Y-m-d H:i:s');
    $sponsored_flag = Apartment::sponsoredAptFlag($apartment);
    $activeSponsorship = null;
    if($sponsored_flag) {
      $activeSponsorshipQuery = ApartmentSponsorship::where('apartment_id', $apartment->id)->where('expiration_date', '>=', $today)->orderBy('expiration_date', 'desc')->first();
      $sponsorship = Sponsorship::select('name')->where('id', $activeSponsorshipQuery->sponsorship_id)->first();
      $startDate = Carbon::createFromFormat('Y-m-d H:i:s', $activeSponsorshipQuery->payment_date)->format('d/m/Y');
      $startTime = Carbon::createFromFormat('Y-m-d H:i:s', $activeSponsorshipQuery->payment_date)->format('H.i');
      $endDate = Carbon::createFromFormat('Y-m-d H:i:s', $activeSponsorshipQuery->expiration_date)->format('d/m/Y');
      $endTime = Carbon::createFromFormat('Y-m-d H:i:s', $activeSponsorshipQuery->expiration_date)->format('H.i');
      $activeSponsorship = [
        'id' => $activeSponsorshipQuery->sponsorship_id,
        'name' => $sponsorship->name,
        'startDate' => $startDate,
        'startTime' => $startTime,
        'endDate' => $endDate,
        'endTime' => $endTime
      ];
    }
    $sponsorships = Sponsorship::all();
    return view('admin.sponsorships.index', compact('sponsorships', 'apartment', 'sponsored_flag', 'activeSponsorship'));
  }
}
