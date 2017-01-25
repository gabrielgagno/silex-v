<?php
/**
 * Routes.php
 * Contains the Routes class
 * @author Gabriel John P. Gagno
 * @version 1.0
 * @copyright 2016 Stratpoint Technologies, Inc.
 * @date 12/15/16
 */

namespace App;


use Silex\Api\ControllerProviderInterface;
use Silex\Application;

class Routes implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $routes = $app['controllers_factory'];
        $routes->get('/applications/', 'App\\Controllers\\ApplicationController::index');
        $routes->get('/applications/{id}', 'App\\Controllers\\ApplicationController::show');
        $routes->put('/applications/{id}', 'App\\Controllers\\ApplicationController::update');
        $routes->post('/applications/', 'App\\Controllers\\ApplicationController::create');
        $routes->delete('/applications/{id}', 'App\\Controllers\\ApplicationController::destroy');
        return $routes;
    }
}
