<?php

namespace App\Exceptions;

use Flugg\Responder\Contracts\Responder;
use Flugg\Responder\Exceptions\Handler as ExceptionHandler;
use Flugg\Responder\Exceptions\Http\HttpException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, $exception)
    {
        $this->convertDefaultException($exception);

        if ($exception instanceof HttpException) {
            return $this->renderResponse($exception);
        }

        if (config('app.debug')) {
            return app(Responder::class)
                ->error((string)$exception->getCode(), $exception->getMessage() . ' ' . $exception->getTraceAsString())
                ->respond(500)
            ;
        }
        return app(Responder::class)
            ->error((string)$exception->getCode(), $exception->getMessage())
            ->respond(500)
        ;
    }
}
