<?php

namespace App\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use Translatable;

    public $translatedAttributes = ['name'];

    public $translationModel = 'App\Entities\Translation\IngredientTranslation';

    /**
     * Ingredient belongs to many foods
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function foods()
    {
        return $this->belongsToMany(Food::class, 'food_ingredient_pivot' , 'ingredient_id', 'food_id');
    }
}
