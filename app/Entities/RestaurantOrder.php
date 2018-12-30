<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class RestaurantOrder extends Model
{
    public $fillable = ['price', 'status', 'restaurant_id', 'name', 'address'];


    /**
     * Order belongs to restaurant
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id', 'id');
    }

    /**
     * Orders belongs to many foods
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function foods()
    {
        return $this->belongsToMany(Food::class, 'restaurant_order_foods', 'order_id', 'food_id');
    }
}
