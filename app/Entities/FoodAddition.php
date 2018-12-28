<?php

namespace App\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class FoodAddition extends Model
{
    use Translatable;

    public $translatedAttributes = ['title'];

    public $translationModel = 'App\Entities\Translation\FoodAdditionTranslation';

    protected $fillable = [
        'category_id', 'price'
    ];

    /**
     * Food additions belong to category
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(FoodCategory::class, 'category_id', 'id');
    }
}
