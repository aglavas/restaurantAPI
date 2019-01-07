<?php

namespace App\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Restaurant extends Model
{
    use Translatable, HasRoles;

    public $translatedAttributes = ['description'];

    public $translationModel = 'App\Entities\Translation\RestaurantTranslation';

    protected $fillable = [
        'address', 'open_hours','delivery', 'delivery_price', 'lat', 'long'
    ];

    protected $guard_name = 'web';


    /**
     * Restaurant has many orders
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(RestaurantOrder::class, 'restaurant_id', 'id');
    }

    /**
     * Restaurant morhps to user
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }

    /**
     * Restaurant has many food categories
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function foodCategories()
    {
        return $this->hasMany(FoodCategory::class, 'restaurant_id', 'id');
    }

    /**
     * Restaurant has many food additions
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function foodAdditions()
    {
        return $this->hasManyThrough(
            FoodAddition::class,
            FoodCategory::class,
            'restaurant_id',
            'category_id',
            'id',
            'id'
        );
    }

    /**
     * Restaurant has many foods
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function foods()
    {
        return $this->hasMany(Food::class, 'restaurant_id', 'id');
    }

    /**
     * Restaurant category belongs to many restaurants
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(RestaurantCategory::class, 'restaurant_category_pivot' ,'restaurant_id', 'category_id');
    }

    /**
     * Restaurant inventory category belongs to many restaurants
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function inventory()
    {
        return $this->belongsToMany(RestaurantInventoryCategory::class, 'restaurant_category_inventory_pivot' ,'restaurant_id', 'inventory_id');
    }

    /**
     * Deletes morphed relation
     *
     * @return bool|null
     * @throws \Exception
     */
    public function delete()
    {
        $result = parent::delete();
        if($result == true)
        {
            $this->user()->delete();

            return true;

        }

        return false;
    }
}
