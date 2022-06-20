<?php
namespace App\Exceptions;

use App\Traits\ApiResponser;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiResponser;
    
    const FOREIGN_KEY_VIOLATION_CODE = 1451;
    protected $dontReport = [
        //
    ];

   
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if($e instanceof ValidationException) {
            return $this->convertValidationExceptionToResponse($e, $request);
        }
        if($e instanceof ModelNotFoundException) {

            $modelName = class_basename($e->getModel());
            return $this->errorResponse("$modelName does not exist with the specified key!", 404);
        }
        if($e instanceof AuthenticationException) {
            $this->unauthenticated($request, $e);
        }
        if($e instanceof AuthorizationException) {
            $this->errorResponse($e->getMessage(), 403);
        }
        if($e instanceof NotFoundHttpException) {
            return $this->errorResponse("The specified URL cannot be found", 404);
        }
        if($e instanceof MethodNotAllowedHttpException) {
            return $this->errorResponse('The specified method for the request is invalid', 405);
        }
        if($e instanceof HttpException) {
            return $this->errorResponse($e->getMessage(), $e->getStatusCode());
        }

        if($e instanceof QueryException) {
            $errorCode = $e->errorInfo[1];

            if($errorCode == self::FOREIGN_KEY_VIOLATION_CODE) {
                return $this->errorResponse('Cannot remove this resource permanently, as it is related with any other resource', 409);
            }
        }

        if(config('app.debug')) {
            return parent::render($request, $e);
        }
        return $this->errorResponse('Unexpected Server Error', 500);
    }

    protected function convertValidationExceptionToResponse(ValidationException $e, $request): JsonResponse
    {
        return $this->errorResponse($e->errors(), 422);
    }

    protected function unauthenticated($request, AuthenticationException $exception): JsonResponse
    {
        return $this->errorResponse("Unauthenticated!", 401);
    }
}
?>
