<?php

namespace App\Validators;

use App\Models\Meal\Meal;
use App\Models\Pivot\BmiPhysiquePlanModel;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CustomValidator
{
    /**
     * Validation rule for checking timestamp that need to be equal or after specified timestamp
     *
     * @param $message
     * @param $attribute
     * @param $rule
     * @param $parameters
     * @return bool
     */
    public function imageExists($message, $attribute, $rule, $parameters)
    {
        $count = DB::table('foods')
            ->where('image_1', $attribute)
            ->orWhere('image_2', $attribute)
            ->orWhere('image_3', $attribute)
            ->orWhere('image_4', $attribute)
            ->orWhere('image_5', $attribute)
            ->orWhere('image_6', $attribute)
            ->count();

        if (!$count) {
            return false;
        }
        return true;
    }
    /**
     *
     * Replacer for custom message
     *
     * @param $message
     * @param $attribute
     * @param $rule
     * @param $parameters
     * @return string
     */
    public function imageExistsReplacer($message, $attribute, $rule, $parameters)
    {
        $message = "Image with that id does not exists.";
        return $message;
    }

}
