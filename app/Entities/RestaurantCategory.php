<?php

namespace App\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class RestaurantCategory extends Model
{
    use Translatable;

    public $translatedAttributes = ['title'];

    public $translationModel = 'App\Entities\Translation\RestaurantCategoryTranslation';

    public $fillable = [''];


    /**
     * Restaurant category belongs to many inventory category
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function inventoryCategory()
    {
        return $this->belongsToMany(RestaurantInventoryCategory::class, 'restaurant_inventory_pivot' ,'restaurant_category_id', 'restaurant_inventory_id');
    }
}
