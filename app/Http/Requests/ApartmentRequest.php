<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApartmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
          'title'          => 'required|min:4|max:255',
          'category'       => 'nullable|min:3|max:255',
          'address'        => 'required|min:3|max:255',
          'n_rooms'        => 'nullable|min:1|integer',
          'n_bathrooms'    => 'nullable|min:1|integer',
          'n_beds'         => 'nullable|min:1|integer',
          'square_meters'  => 'nullable|min:1|integer',
          'price'          => 'nullable|min:3',
          'cover_image'    => 'nullable|min:5'
        ];
    }

    public function messages(){
      return [
          'title.required' => 'Il titolo è un campo obbligatorio',
          'title.min' => 'Il titolo deve avere minimo :min caratteri',
          'title.max' => 'Il titolo può avere al massimo :max caratteri',
          'category.min' => 'La categoria deve avere minimo :min caratteri',
          'category.max' => 'La categoria può avere al massimo :max caratteri',
          'address.required' => 'L\'indirizzo è un campo obbligatorio',
          'address.min' => 'L\' indirizzo deve avere minimo :min caratteri',
          'address.max' => 'L\' indirizzo può avere al massimo :max caratteri',
          'n_rooms.min' => 'Il numero di stanze dev\'essere un valore superiore o uguale a 1',
          'n_rooms.integer' => 'Il numero di stanze dev\'essere un valore intero',
          'n_bathrooms.min' => 'Il numero di bagni dev\'essere un valore superiore o uguale a 1',
          'n_bathrooms.integer' => 'Il numero di bagni dev\'essere un valore intero',
          'n_beds.min' => 'Il numero di letti dev\'essere un valore superiore o uguale a 1',
          'n_beds.integer' => 'Il numero di letti dev\'essere un valore intero',
          'square_meters.min' => 'Il numero di metri quadri dev\'essere un valore superiore o uguale a 1',
          'square_meters.integer' => 'Il numero di metri quadri dev\'essere un valore intero',
          'price.min' => 'Il prezzo dev\'essere un valore superiore o uguale a 1',
          'cover_image.min' => 'L\'immagine deve avere minimo :min caratteri',
      ];
  }
}
