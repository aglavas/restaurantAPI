<?php

namespace App\Entities\Translation;

use Illuminate\Database\Eloquent\Model;

class IngredientTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = ['name'];
}
