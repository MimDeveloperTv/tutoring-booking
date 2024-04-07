<?php

namespace App\Exceptions;

use App\Traits\ResponseTemplate;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use function PHPUnit\Framework\isInstanceOf;
use Exception;

class PreventServiceModelSystemModificationException extends Exception
{
    use ResponseTemplate;
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
//    protected $dontFlash = [
//        'current_password',
//        'password',
//        'password_confirmation',
//    ];

    /**
     * Register the exception handling callbacks for the application.
     */
//    public function register(): void
//    {
//        $this->reportable(function (Throwable $e) {
//            //
//        });
//    }

    public function render()
    {
        $this->setErrors(["message" => "You are not allowed to Modify System Services"]);
        $this->setStatus(403);
        return $this->response();
    }
}
