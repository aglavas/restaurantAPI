<?php

namespace App\Filters;

use Illuminate\Http\Request;
use Carbon\Carbon;


class UserFilter extends QueryFilters
{

    /**
     * Create a new QueryFilters instance.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    /**
     * Filter users by name
     *
     * @param $name
     */
    public function name($name)
    {
        $this->builder->where('name','=', $name);
    }

    /**
     * Filter users by type
     *
     * @param $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function type($type)
    {
        $finalType = '';

        if($type === 'restaurant') {
            $finalType = 'App\Entities\Restaurant';
        } elseif ($type === 'winery') {
            $finalType = 'App\Entities\Winery';
        }

        return $this->builder->where('userable_type', $finalType);
    }
}
