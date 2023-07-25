<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    public function apartment() {
        return $this->belongsTo(Apartment::class);
    }

    protected $fillable = [
      'apartment_id',
      'sender_name',
      'sender_lastname',
      'sender_email',
      'text',
  ];
}
