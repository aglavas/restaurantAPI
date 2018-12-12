<?php

namespace App\Entities\Translation;

use Illuminate\Database\Eloquent\Model;

class RestaurantTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = ['description'];
}
