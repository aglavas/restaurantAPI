<?php

namespace App\Entities\Translation;

use Illuminate\Database\Eloquent\Model;

class RestaurantCategoryTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = ['title'];
}
