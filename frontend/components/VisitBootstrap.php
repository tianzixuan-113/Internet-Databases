<?php
namespace frontend\components;

use Yii;
use yii\base\BootstrapInterface;

class VisitBootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        if (!$app instanceof \yii\web\Application) {
            return;
        }
        $app->on(\yii\web\Application::EVENT_BEFORE_REQUEST, function() use ($app) {
            $request = $app->request;
            $route = $app->requestedRoute ?: $request->url;
            // Skip assets and debug
            if (strpos($route, 'assets') !== false || strpos($route, 'debug') !== false) {
                return;
            }
            $cache = Yii::$app->cache;
            $dayKey = 'fvisit:day:' . date('Y-m-d');
            $routesKey = 'fvisit:routes';
            // increment day counter
            $count = (int)$cache->get($dayKey);
            $cache->set($dayKey, $count + 1, 7 * 86400);
            // update top routes map
            $routes = $cache->get($routesKey);
            if (!is_array($routes)) { $routes = []; }
            $r = (string)$route;
            $routes[$r] = isset($routes[$r]) ? ((int)$routes[$r] + 1) : 1;
            $cache->set($routesKey, $routes, 30 * 86400);
        });
    }
}
