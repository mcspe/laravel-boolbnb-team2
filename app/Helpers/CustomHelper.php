<?php

namespace App\Helpers;
use App\Models\Apartment;
use Illuminate\Support\Str;

class CustomHelper {
    public static function generateSlug($str){

    $slug = Str::slug($str, '-');
    $original_slug = $slug;
    $slug_exists = Apartment::where('slug', $slug)->first();
    $c = 1;
    while($slug_exists){
        $slug = $original_slug . '-' . $c;
        $slug_exists = Apartment::where('slug', $slug)->first();
        $c++;
    }

    return $slug;
}

}
