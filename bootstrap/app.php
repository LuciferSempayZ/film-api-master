<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        apiPrefix: 'api',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectTo( fn () => throw new \App\Exceptions\ApiException('Unauthorized', 401));
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (NotFoundHttpException $e, $request) {
            if ($request->is('api/*') ) {
                throw new \App\Exceptions\ApiException('Not found', 404);
            }
        });
        $exceptions->shouldRenderJsonWhen(fn(\Illuminate\Http\Request $request) => $request->is('api/*') );
    })->create();
