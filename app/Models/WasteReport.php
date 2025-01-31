<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WasteReport extends Model
{
  protected $fillable = [
    'user_id',
    'photo',
    'location',
    'latitude',
    'longitude',
    'description',
    'status'
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
