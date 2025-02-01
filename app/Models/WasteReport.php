<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WasteReport extends Model
{
  protected $fillable = [
    'user_id',
    'collector_id',
    'photo',
    'location',
    'latitude',
    'longitude',
    'description',
    'status',
    'collected_at',
    'completed_at'
  ];

  protected $casts = [
    'collected_at' => 'datetime',
    'completed_at' => 'datetime',
    'created_at' => 'datetime',
    'updated_at' => 'datetime'
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
