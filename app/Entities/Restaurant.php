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