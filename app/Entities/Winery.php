<?php

namespace App\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Winery extends Model
{
    use Translatable, HasRoles;

    public $translatedAttributes = ['description'];

    public $translationModel = 'App\Entities\Translation\WineryTranslation';

    protected $fillable = [
        'address', 'open_hours', 'lat', 'long'
    ];

    protected $guard_name = 'web';

    /**
     * Winery morhps to user
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
