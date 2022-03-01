<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class BeforeRequest
{
    public function handle(Request $request, Closure $next)
    {
        $request->request->add([
            'prometheus_metrics_request_start_time' => new Carbon(),
        ]);

        return $next($request);
    }
}
