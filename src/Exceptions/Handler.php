<?php

namespace Juzaweb\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     * @throws Exception
     */
    public function render($request, Exception $exception)
    {
        if ($this->is404Exception($exception)) {
            if ($request->is(config('juzaweb.admin_prefix') . '/*')) {
                return response()->view('juzaweb::404');
            }

            if (view()->exists('theme::404')) {
                return response()->view('theme::404');
            }

            return response()->view('juzaweb::404');
        }

        return parent::render($request, $exception);
    }

    protected function is404Exception($exception)
    {
        switch ($exception) {
            case $exception instanceof NotFoundHttpException:
                return true;
            case $exception instanceof ModelNotFoundException:
                return true;
        }

        return false;
    }
}
