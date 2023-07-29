<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Apartment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
      'user_id',
      'title',
      'slug',
      'category',
      'address',
      'latitude_longitude',
      'n_rooms',
      'n_bathrooms',
      'n_beds',
      'square_meters',
      'price',
      'cover_image',
      'is_visible',
  ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function services() {
        return $this->belongsToMany(Service::class);
    }

    public function sponsorships() {
        return $this->belongsToMany(Sponsorship::class);
    }

    public function visits() {
        return $this->hasMany(Visit::class);
    }

    public function messages() {
        return $this->hasMany(Message::class);
    }

    public static function getCoordinates($address) {

      /*
      First attempt
      $exampleQuerySearch = 'https://api.tomtom.com/search/2/search/via%20carlo%20verre%2044.json?typeahead=false&limit=1&view=Unified&key=jMP7C6DHaaq8PNVgJUg740ueeMPlH0xY';
      */

      // URL Base
      $baseUrl = 'https://api.tomtom.com/search/2/search/';

      // Function for slug the address
      $addressToSearch = Str::slug($address, '%20');

      // Type of query which returns a json
      $query = '.json?typeahead=false&limit=1&view=Unified&key=';

      // Api key
      $apiKey = env("API_IT_KEY");

      // Receive contents in a json
      $addressJsonResults = file_get_contents($baseUrl . $addressToSearch . $query . $apiKey);

      // Decoding json
      $decodingAddress = json_decode($addressJsonResults, JSON_PRETTY_PRINT);

      // Get latitude and longitude from json array
      $latitude = $decodingAddress['results'][0]['position']['lat'];
      $longitude = $decodingAddress['results'][0]['position']['lon'];

      // Get coordinates with DB syntax
      $coordinates = "ST_GeomFromText('POINT($longitude $latitude)')";

      return $coordinates;
    }

    public static function sponsoredAptFlag($apartment) {
      $sponsoredApt = Apartment::whereHas('sponsorships', function($q){
        $today = Carbon::now()->format('Y-m-d H:i:s');
        $q->where('expiration_date', '>=', $today);
      })->pluck('id')->all();

      if (in_array($apartment->id, $sponsoredApt)) {
        return 1;
      } else {
        return 0;
      }
    }
}
