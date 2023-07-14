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
        return false;
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
          'price'          => 'nullable|min:3|numeric',
          'cover_image'    => 'nullable|min:5|',
          'is_visible'     => 'required|boolean',
          'user_id'        => 'required',
        ];
    }
}
