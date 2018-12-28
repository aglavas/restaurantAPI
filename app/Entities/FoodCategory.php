<?php

namespace App\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class FoodCategory extends Model
{
    use Translatable;

    public $translatedAttributes = ['title'];

    public $translationModel = 'App\Entities\Translation\FoodCategoryTranslation';

    protected $fillable = [
        'restaurant_id'
    ];

    /**
     * Food categories has many foods
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function foods()
    {
        return $this->hasMany(Food::class, 'category_id', 'id');
    }
}
