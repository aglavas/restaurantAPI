<?php

namespace App\Entities\Translation;

use Illuminate\Database\Eloquent\Model;

class RestaurantInventoryCategoryTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = ['title'];
}
