<?php

namespace App\Containers\Release\Models;

use App\Ship\Parents\Models\Model;

class Release extends Model
{
  protected $guard_name = 'web';
  protected $fillable = [
    'name',
    'date_created',
    'title_description',
    'detail_description',
    'is_publish'

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
  protected $resourceKey = 'releases';
}
