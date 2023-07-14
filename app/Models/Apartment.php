<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

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
      $apiKey = 'jMP7C6DHaaq8PNVgJUg740ueeMPlH0xY';

      // Receive contents in a json
      $addressJsonResults = file_get_contents($baseUrl . $addressToSearch . $query . $apiKey);

      // Decoding json
      $decodingAddress = json_decode($addressJsonResults, JSON_PRETTY_PRINT);

      // Get latitude and longitude from json array
      $latitude = $decodingAddress['results'][0]['position']['lat'];
      $longitude = $decodingAddress['results'][0]['position']['lon'];

      // Get coordinates with DB syntax
      $coordinates = "ST_GeomFromText('POINT($latitude $longitude)')";

      return $coordinates;
    }
}
