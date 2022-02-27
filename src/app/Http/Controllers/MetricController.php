<?php

namespace App\Http\Controllers;

use Prometheus\CollectorRegistry;
use Prometheus\RenderTextFormat;
use Prometheus\Storage\Redis;

class MetricController extends Controller
{
    public function metrics()
    {
        $registry = new CollectorRegistry(new Redis(config('database.redis.default')));
        $renderer = new RenderTextFormat();

        return response($renderer->render($registry->getMetricFamilySamples()))
            ->header('Content-Type', RenderTextFormat::MIME_TYPE);
    }
}
