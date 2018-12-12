<?php

namespace App\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{

    use Translatable;

    public $translatedAttributes = ['description'];

    public $translationModel = 'App\Entities\Translation\RestaurantTranslation';

    protected $fillable = [
        'address', 'open_hours','delivery', 'delivery_price', 'lat', 'long'
    ];

    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }

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
