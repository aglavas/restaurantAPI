<?php

namespace App\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class RestaurantInventoryCategory extends Model
{
    use Translatable;

    public $translatedAttributes = ['title'];

    public $translationModel = 'App\Entities\Translation\RestaurantInventoryCategoryTranslation';

    public $fillable = [''];

    /**
     * Restaurant inventory category belongs to many restaurant category
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function restaurantCategory()
    {
        return $this->belongsToMany(RestaurantCategory::class, 'restaurant_inventory_pivot' , 'restaurant_inventory_id', 'restaurant_category_id');
    }
}
