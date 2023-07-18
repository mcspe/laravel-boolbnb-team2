<?php

namespace App\Http\Controllers;

use App\Helpers\CustomHelper;
use App\Models\Apartment;
use App\Models\Message;
use App\Models\Service;
use App\Models\Sponsorship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ApartmentRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apartments = Apartment::where("user_id", Auth::id())->get();
        $n_apartments = Apartment::where("user_id", Auth::id())->count();
        return view('admin.apartments.index', compact('apartments', "n_apartments"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

      $apartment_service = Service::all();
      $apartment_sponsorship = Sponsorship::all();

      return view('admin.apartments.create', compact('apartment_service', 'apartment_sponsorship'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ApartmentRequest $request)
    {
        $form_data = $request->all();

        $form_data['slug'] = CustomHelper::generateSlug($form_data['title']);

        $form_data['user_id']  = Auth::id();

        $form_data['latitude_longitude'] = DB::raw(Apartment::getCoordinates($form_data['address']));

        if ($request->hasFile('coverImagePreview')) {

          $form_data = CustomHelper::saveCoverImage('coverImagePreview', $request, $form_data, new Apartment());

        }

        $new_apartment = new Apartment();

        $new_apartment->fill($form_data);

        $new_apartment->save();

        // if (array_key_exists('services', $form_data)) {
        //   $new_apartment->services()->attach($form_data['services']);
        // }

        // if (array_key_exists('sponsorships', $form_data)) {
        //   $new_apartment->sponsorships()->attach($form_data['sponsorships']);
        // }

        return redirect()->route('admin.apartments.show', $new_apartment);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function show(Apartment $apartment)
    {
        $latitude = DB::select(DB::raw("SELECT ST_X(`latitude_longitude`) FROM `apartments` WHERE (`id` = $apartment->id)"));
        $longitude = DB::select(DB::raw("SELECT ST_Y(`latitude_longitude`) FROM `apartments` WHERE (`id` = $apartment->id)"));
        $lat = json_decode(json_encode($latitude), true);
        $lat = $lat[0]['ST_X(`latitude_longitude`)'];
        $lng = json_decode(json_encode($longitude), true);
        $lng = $lng[0]['ST_Y(`latitude_longitude`)'];

        return view('admin.apartments.show', compact('apartment', 'lat', 'lng'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function edit(Apartment $apartment)
    {
        $apartment_service = Service::all();
        $apartment_message = Message::all();
        $apartment_sponsorship = Sponsorship::all();

        return view('admin.apartments.edit', compact('apartment', 'apartment_service', 'apartment_message', 'apartment_sponsorship'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function update(ApartmentRequest $request, Apartment $apartment)
    {

      $form_data = $request->all();

      if($form_data['title'] !== $apartment->title){
          $form_data['slug'] = CustomHelper::generateSlug($form_data['title']);
      }else{
          $form_data['slug'] = $apartment->slug;
      }

      $form_data['latitude_longitude'] = DB::raw(Apartment::getCoordinates($form_data['address']));


      if ($request->hasFile('coverImagePreview')) {

        if($apartment->cover_image) {

          Storage::disk('public')->delete($apartment->cover_image);

        }

        $form_data = CustomHelper::saveCoverImage('coverImagePreview', $request, $form_data, new Apartment());

      }


      if (array_key_exists('services', $form_data)) {
          $apartment->services()->sync($form_data['services']);
      }else{
          $apartment->services()->detach();
      }

      if (array_key_exists('sponsorships', $form_data)) {
          $apartment->sponsorships()->sync($form_data['sponsorships']);
      }else{
          $apartment->sponsorships()->detach();
      }

      $apartment->update($form_data);

      return redirect()->route('admin.apartments.show', $apartment);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Apartment $apartment)
    {

      if($apartment->cover_image) {
        Storage::disk('public')->delete($apartment->cover_image);
    }

      $apartment->delete();

      return redirect()->route('admin.apartments.index')->with('deleted', "The Apartment '$apartment->title' <- has been succesfully deleted");
    }
}
