<?php

namespace App\Helpers;
use App\Models\Apartment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CustomHelper {


  public static function generateUniqueSlug($str, $model){

    $slug = Str::slug($str, '-');
    $original_slug = $slug;
    $slug_exists = $model::where('slug', $slug)->withTrashed()->first();
    $c = 1;

    while($slug_exists){
        $slug = $original_slug . '-' . $c;
        //  && ! $this->forceDeleting
        $slug_exists = $model::where('slug', $slug)->withTrashed()->first();
        $c++;
    }

    return $slug;
  }

  public static function saveImage($image, $request, $form_data, $model) {

    $original_name = $request->file($image)->getClientOriginalName();
    $nameonly = preg_replace('/\..+$/', '', $original_name);
    $ext = $request->file($image)->getClientOriginalExtension();

    $file_name = Str::slug($nameonly, '-') . '.' . $ext;
    $path = 'uploads';

    if($model::where('cover_image', $path . '/' . $file_name)->first()) {
      $nameonly .= '-' . rand(1000,9999);
      $file_name = Str::slug($nameonly, '-') . '.' . $ext;
    }

    $form_data['cover_image'] = Storage::putFileAs($path, $form_data[$image], $file_name);

    return $form_data;
  }



}
