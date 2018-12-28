<?php

namespace App\Entities\Translation;

use Illuminate\Database\Eloquent\Model;

class FoodTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = ['name', 'description'];
}
