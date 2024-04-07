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

class Handler extends ExceptionHandler
{
    use ResponseTemplate;
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if($request->wantsJson())
        {
            if($e instanceof ModelNotFoundException)
            {
                $this->setErrors([
                    'message' => 'Not fount'
                ])->setStatus(404);
            }
            if ($e instanceof AuthenticationException){
                $this->setErrors([
                    'message' => $this->unauthenticated($request,$e)
                ])->setStatus(401);
            }
            if ($e instanceof ValidationException){
                $this->setErrors( $this->convertValidationExceptionToResponse($e,$request))->setStatus(422);
            }

            return parent::render($request, $e);
        }else{
            return parent::render($request, $e);
        }

    }
}
