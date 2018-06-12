<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ResponseMiddleware
{

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

            $headers['Cache-Control'] = 'public, max-age=3600';
        }

        $headers['Content-Type'] = 'application/json';

        $response->withHeaders($headers);

        return $response;
    }
}
