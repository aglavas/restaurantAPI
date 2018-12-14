<?php

namespace App\Entities\Translation;

use Illuminate\Database\Eloquent\Model;

class WineryTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = ['description'];
}
