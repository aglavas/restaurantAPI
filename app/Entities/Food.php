<?php

namespace App\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use Translatable;

    public $translatedAttributes = ['name', 'description'];

    public $translationModel = 'App\Entities\Translation\FoodTranslation';

    protected $fillable = [
        'price', 'calories', 'slug', 'restaurant_id', 'category_id'
    ];

    /**
     * Food belongs to many ingredients
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'food_ingredient_pivot' ,'food_id', 'ingredient_id');
    }

    /**
     * Food belongs to restaurant
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class,'restaurant_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(FoodCategory::class,'category_id', 'id');
    }
}
