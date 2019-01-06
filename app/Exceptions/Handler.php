<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        //dd($exception);

        if ($exception instanceof ValidationException) {
            return $this->validationOutput($exception);
        } elseif ($exception instanceof ModelNotFoundException) {
            return $this->errorOutput('Resource not found.', 404);
        } elseif ($exception instanceof AuthenticationException) {
            return $this->errorOutput('Unauthenticated.', 401);
        } elseif ($exception instanceof NotFoundHttpException) {
            return $this->errorOutput('Route not found.', 404);
        } elseif ($exception instanceof AuthorizationException) {
            return $this->errorOutput($exception->getMessage(), 403);
        }

        return $this->errorOutput($exception->getMessage(), 500);
    }

    public function errorOutput($message, $code )
    {
        $res =  [
            'error' => [
                [
                    'type' => "general",
                    'field' => null,
                    'message' => $message
                ]
            ]
        ];

        return ( new Response($res , $code) )->header('Content-Type', 'application/json');
    }


    public function validationOutput($e)
    {
        /** @var Validator $validator */
        $validator = $e->validator;

        $messages = $validator->getMessageBag()->getMessages();

        $key = key($messages);

        $res = [
            'error' => [
                [
                    'type' => "validation",
                    'field' => $key,
                    'message' => $messages[$key][0]
                ]
            ]
        ];

        return ( new Response($res , 422) )->header('Content-Type', 'application/json');

    }
}
