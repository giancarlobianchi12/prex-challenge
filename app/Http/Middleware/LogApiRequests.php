<?php

namespace App\Http\Middleware;

use App\Jobs\LogApiRequestJob;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogApiRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $userId = $request->user() ? $request->user()->id : null;

        LogApiRequestJob::dispatch(
            $userId,
            $request->path(),
            $request->all(),
            $response->status(),
            $response->getContent(),
            $request->ip()
        );

        return $response;
    }
}
