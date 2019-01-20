<?php

namespace App\Http\Middleware;

use Closure;


class APIKey 
{
    const KEY = "81E852E12FD558B2E036B53039D8C721491B0E4A";

    public function handle($request, Closure $next)
    {
        //dd($request->apiKey);die;
        if ($request->apiKey == '') {
            return redirect('/');

        }else{
            if ($request->apiKey == self::KEY) {
                return $next($request);
            } else {
                return response('Invalid access key');
            }
        }
    }
}

