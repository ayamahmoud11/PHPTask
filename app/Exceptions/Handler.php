<?php

namespace App\Exceptions;

use Exception; // Add this line
use Throwable; // Make sure this is also present
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
public function render($request, Throwable $e)
{
    if ($request->wantsJson()) {
        return $this->handleApiException($request, $e);
    }

    return parent::render($request, $e);
}

protected function handleApiException($request, Throwable $exception)
{
    $exception = $this->prepareException($exception);

    if ($exception instanceof HttpResponseException) {
        $exception = $exception->getResponse();
    }

    if ($exception instanceof AuthenticationException) {
        return $this->error('Unauthenticated', 401);
    }

    if ($exception instanceof ValidationException) {
        return $this->error($exception->getMessage(), 422, $exception->errors());
    }

    return $this->error(
        $exception->getMessage(),
        method_exists($exception, 'getStatusCode') 
            ? $exception->getStatusCode() 
            : 500
    );
}
}