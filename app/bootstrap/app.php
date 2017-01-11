<?php
/**
 * bootstrap/app.php
 * The main loading file of this P2ME API Middleware
 * @author Gabriel John P. Gagno
 * @version 1.0
 * @copyright 2016 Stratpoint Technologies, Inc.
 * @date 12/15/16
 */
require_once __DIR__.'/../../vendor/autoload.php';

use App\Libraries\Util;

# initialize Silex Application Instance
$app = new Silex\Application();
$app->boot();


# register config service provider for entire app (NOTE: THIS HAS TO GO FIRST BEFORE
# THE OTHER CONFIGURABLES)
$app->register(new Igorw\Silex\ConfigServiceProvider(__DIR__."/../../config/app.php"));

# initialize environment here
try{
    $app['env'] = new Dotenv\Dotenv(__DIR__.'/../../', '.env.'.$app['environment']);
    $app['env']->load();
}
catch (\Exception $e) {
    $app->json(['error' => 500, 'error_description' => 'Environment Not Found'], 500)->send();
    die();
}

$app['debug'] = filter_var(Util::env('APP_DEBUG', false), FILTER_VALIDATE_BOOLEAN);
# register services

# register logger service provider
$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => __DIR__.'/../../logs/log-'.date('Y-m-d').'.log',
    'monolog.name' => $app['name']
));

# register security service provider
$app->register(new Silex\Provider\SecurityServiceProvider());

# register validator provider (optional)
$app->register(new Silex\Provider\ValidatorServiceProvider());

# register config service provider for database
$app->register(new Igorw\Silex\ConfigServiceProvider(__DIR__."/../../config/database.php"));

# register config service provider for constants
$app->register(new \Igorw\Silex\ConfigServiceProvider(__DIR__."/../../config/constants.php"));

# register config service provider for doctrine
$app->register(new Silex\Provider\DoctrineServiceProvider());

# register doctrine ORM
$app->register(new \Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider());

# Re
$app->error(function (\Exception $e, $code) use ($app) {
    return $app->json(array('error'=>$e->getMessage()));
});
# routes
$app->mount('/', new \App\Routes());

# initialize app to be accessible everywhere
\App\Libraries\Util::initialize($app);