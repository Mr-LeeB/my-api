<?php

namespace App\Containers\Welcome\Models;

use App\Ship\Parents\Models\Model;

class Student extends Model
{
  protected $fillable = [
    'name',
    'content',
  ];

  protected $attributes = [

  ];

  protected $hidden = [

  ];

  protected $casts = [

  ];

  protected $dates = [
    'created_at',
    'updated_at',
  ];

  /**
   * A resource key to be used by the the JSON API Serializer responses.
   */
  protected $resourceKey = 'students';
}