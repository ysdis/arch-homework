<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Prometheus\CollectorRegistry;
use Prometheus\Exception\MetricsRegistrationException;
use Prometheus\Storage\Redis;

class TerminatingRequest
{
    /**
     * @throws MetricsRegistrationException
     */
    public function handle(Request $request, Closure $next)
    {
        /** @var Response $response */
        $response = $next($request);

        $registry = new CollectorRegistry(new Redis(config('database.redis.default')));

        $counter = $registry->getOrRegisterCounter(
            'requests',
            'app_request_count',
            'Requests count per endpoint',
            ['method', 'endpoint', 'http_status']
        );

        $histogram = $registry->getOrRegisterHistogram(
            'requests',
            'app_request_latency_seconds',
            'Latency per endpoint',
            ['method', 'endpoint'],
            [
                0.005,
                0.01,
                0.025,
                0.05,
                0.075,
                0.1,
                0.25,
                0.5,
                0.75,
                1.0,
                2.5,
                5.0,
                7.5,
                10.0,
            ]
        );

        $counter->incBy(1, [
            $request->getMethod(),
            $request->getPathInfo(),
            $response->getStatusCode(),
        ]);

        $histogram->observe(
            (new Carbon())->floatDiffInSeconds($request->request->get('prometheus_metrics_request_start_time')),
            [
                $request->getMethod(),
                $request->getPathInfo(),
            ]
        );

        return $response;
    }
}
