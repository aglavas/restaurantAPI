<?php
/**
 * Created by PhpStorm.
 * User: Korisnik
 * Date: 3.10.2016.
 * Time: 15:36
 */

namespace App\Http\Requests;

use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Http\FormRequest;

class FoundationRequest extends FormRequest
{
    protected $http_verb;
    public $request_instance;

//    public function response(array $errors)
//    {
//        if ($this->ajax() || $this->wantsJson() || env('APP_ENV') == 'local')
//        {
//            throw new \Illuminate\Validation\ValidationException("Unprocessable Entity.", $errors,400);
//        }
//
//        return $this->redirector->to($this->getRedirectUrl())
//            ->withInput($this->except($this->dontFlash))
//            ->withErrors($errors, $this->errorBag);
//    }

//    protected function getValidatorInstance()
//    {
//        $this->request_instance = $this->instance();
//
//        $this->httpVerb = $this->request_instance->method();
//
//        $validator = parent::getValidatorInstance();
//
//        //Validator extending logic goes here
//        return $validator;
//    }

    public function all($keys = null)
    {
        return array_replace_recursive(
            parent::all(),
            $this->route()->parameters()
        );
    }


}
