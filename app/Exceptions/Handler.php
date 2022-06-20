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
    /**
     * A list of the exception types that are not reported.
     *
     * @var  array
     */
    const FOREIGN_KEY_VIOLATION_CODE = 1451;
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var  array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return  void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
//        dd($e);
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
            $errorCode = $e->errorInfo[1]; // gives the SQL error code. can find with dd() if u can generate QueryException

            if($errorCode == self::FOREIGN_KEY_VIOLATION_CODE) {
                return $this->errorResponse('Cannot remove this resource permanently, as it is related with any other resource', 409);
            }
        }

        if(config('app.debug')) {
            return parent::render($request, $e);
        }
        return $this->errorResponse('Unexpected Server Error', 500);
    }

    /**
     * Create a response object from the given validation exception.
     *
     * @param  \Illuminate\Validation\ValidationException $e
     * @param  \Illuminate\Http\Request $request
     * @return  JsonResponse
     */
    protected function convertValidationExceptionToResponse(ValidationException $e, $request): JsonResponse
    {
        return $this->errorResponse($e->errors(), 422);
    }

    /**
     * Convert an authentication exception into a response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Illuminate\Auth\AuthenticationException $exception
     * @return  JsonResponse
     */
    protected function unauthenticated($request, AuthenticationException $exception): JsonResponse
    {
        return $this->errorResponse("Unauthenticated!", 401);
    }
}
?>
