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

      $services = Service::all();
      $src = asset('storage/uploads/img-placeholder.png');


      return view('admin.apartments.create', compact('services', 'src'));

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

        $form_data['slug'] = CustomHelper::generateUniqueSlug($form_data['title'], new Apartment());

        $form_data['user_id']  = Auth::id();

        $form_data['latitude_longitude'] = DB::raw(Apartment::getCoordinates($form_data['address']));

        if ($request->hasFile('cover_image')) {

          $form_data = CustomHelper::saveImage('cover_image', $request, $form_data, new Apartment());

        }

        $new_apartment = new Apartment();

        $new_apartment->fill($form_data);

        $new_apartment->save();


        if (array_key_exists('services', $form_data)) {
          $new_apartment->services()->attach($form_data['services']);
        }

        // TODO: Controllare che questo comando non vada prima di save!!!!
        if (!(array_key_exists('is_visible', $form_data))) {
          $form_data['is_visible'] = 0;
        }

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
        $latitude = DB::select(DB::raw("SELECT ST_Y(`latitude_longitude`) FROM `apartments` WHERE (`id` = $apartment->id)"));
        $longitude = DB::select(DB::raw("SELECT ST_X(`latitude_longitude`) FROM `apartments` WHERE (`id` = $apartment->id)"));
        $lat = json_decode(json_encode($latitude), true);
        $lat = $lat[0]['ST_Y(`latitude_longitude`)'];
        $lng = json_decode(json_encode($longitude), true);
        $lng = $lng[0]['ST_X(`latitude_longitude`)'];
        $apiKey = env("API_IT_KEY");
        $sponsored_flag = Apartment::sponsoredAptFlag($apartment);


        if($apartment->user_id != Auth::id()) {
          return redirect()->route('admin.apartments.index')->with('not_authorized', "La pagina che stai tentando di visualizzare non esiste");
        }

        return view('admin.apartments.show', compact('apartment', 'lat', 'lng', 'apiKey', 'sponsored_flag'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function edit(Apartment $apartment)
    {
        $services = Service::all();
        $src = asset('storage/' . $apartment->cover_image);
        $noImgSrc = asset('storage/uploads/img-placeholder.png');


        if($apartment->user_id != Auth::id()) {
          return redirect()->route('admin.apartments.index')->with('not_authorized', "La pagina che stai tentando di visualizzare non esiste");
        }

        return view('admin.apartments.edit', compact('apartment', 'services', 'src', 'noImgSrc'));
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
          $form_data['slug'] = CustomHelper::generateUniqueSlug($form_data['title'], new Apartment());
      }else{
          $form_data['slug'] = $apartment->slug;
      }

      $form_data['latitude_longitude'] = DB::raw(Apartment::getCoordinates($form_data['address']));


      if ($request->hasFile('cover_image')) {

        if($apartment->cover_image) {

          Storage::disk('public')->delete($apartment->cover_image);

        }

        $form_data = CustomHelper::saveImage('cover_image', $request, $form_data, new Apartment());

      }


      if (array_key_exists('services', $form_data)) {
          $apartment->services()->sync($form_data['services']);
      }else{
          $apartment->services()->detach();
      }

      if(!array_key_exists('is_visible', $form_data)) {
        $form_data['is_visible'] = 0;
      }
      $apartment->update($form_data);

      // TODO: Controllare che non sia una ripetizione
      if(array_key_exists('services', $form_data)){
        $apartment->services()->sync($form_data['services']);
      }else{
        $apartment->services()->detach();
      }

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

      return redirect()->route('admin.apartments.index')->with('deleted', "L'immobile '$apartment->title' è stato eliminato correttamente");
    }
}
