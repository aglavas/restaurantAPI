<?php

namespace App\Entities\Translation;

use Illuminate\Database\Eloquent\Model;

class FoodAdditionTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = ['title'];
}
