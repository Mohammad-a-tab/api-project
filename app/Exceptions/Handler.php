<?php

namespace App\Exceptions;

use App\Traits\JsonResponseTrait;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    use JsonResponseTrait;
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
        if (Str::contains($request->url(), 'api/v1')) {
            if ($e instanceof ValidationException) {
                return $this->errorResponse('Error Validation', 400, $e->errors());
            }

        }
        return parent::render($request, $e);
    }
}
