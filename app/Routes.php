<?php
/**
 * Created by IntelliJ IDEA.
 * User: gjpgagno
 * Date: 12/15/16
 * Time: 3:04 PM
 */

namespace App;


use Silex\Api\ControllerProviderInterface;
use Silex\Application;

class Routes implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $routes = $app['controllers_factory'];
        $routes->get('/applications', 'App\\Controllers\\ApplicationController::index');
        return $routes;
    }
}