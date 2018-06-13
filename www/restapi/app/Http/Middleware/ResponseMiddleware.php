<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ResponseMiddleware
{
    const CACHE_AGE = 3600;

    public function handle(Request $request, Closure $next)
    {
        /** @var \Illuminate\Http\Response $response */
        $response = $next($request);

        if ($request->isMethod(Request::METHOD_GET)) {
            $etag        = md5($response->getContent());
            $requestEtag = str_replace('"', '', $request->getETags());
            if ($requestEtag && $requestEtag[0] == $etag) {
                $response->setNotModified();
            }
            $response->setEtag($etag);

            $headers['Cache-Control'] = 'public, max-age=' . static::CACHE_AGE;
        }

        $headers['Content-Type'] = 'application/json';

        $response->withHeaders($headers);

        return $response;
    }
}
