<?php
/**
 * bootstrap/bootstrap.php
 * The main loading file of this P2ME API Middleware
 * @author Gabriel John P. Gagno
 * @author Jose Carlo Macariola
 * @version 1.1
 * @copyright 2016 Stratpoint Technologies, Inc.
 * @date 12/15/16
 */
require_once __DIR__ . '/../vendor/autoload.php';

# use libraries
use App\Libraries\Util;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

# find for .env.* or .env file in root. if it does not exist, die
# if .env exists, automatic production $environment
# else check for .env.* and make it the environment variable
$environment = null;
$envFile = glob(__DIR__.'/../.env');
$count = count($envFile);
if($count!=0) {
    $environment = '';
}
else {
    $envFile = glob(__DIR__.'/../.env.*');
    $count = count($envFile);
    switch($count) {
        case 0:
            die("No environment file found");
            break;
        case 1:
            break;
        default:
            die("More than one environment file found");
            break;
    }
    $envFile = explode('.',$envFile[0]);
    $environment = $envFile[count($envFile)-1];
}

#set config path
$config_path = $environment==''? __DIR__ . "/../config/production" :__DIR__."/../config/{$environment}";

define("ROOT", __DIR__ . "/../");

define("DEFAULT_LANGUAGE", "en");

define("DEFAULT_MESSAGE_GROUP", "generic");

define("DEFAULT_MESSAGE_SUBGROUP", "message");

# initialize Silex Application Instance
$app = new Silex\Application();
$app->boot();


# register config service provider for entire app (NOTE: THIS HAS TO GO FIRST BEFORE
# THE OTHER CONFIGURABLES)
$app->register(new Igorw\Silex\ConfigServiceProvider($config_path."/app.php"));

 # initialize environment here
try{
//$app['env'] = new Dotenv\Dotenv(__DIR__.'/../../', '.env.'.$environment);
    $app['env'] = new Dotenv\Dotenv(__DIR__ . '/../', $environment==''?'.env':'.env.'.$environment);
    $app['env']->load();
}
catch (\Exception $e) {
    $app->json(['error' => 500, 'error_description' => 'Environment Not Found'], 500)->send();
    die();
}

# Switch $app['debug'] to on or off
$app['debug'] = filter_var(Util::env('APP_DEBUG', false), FILTER_VALIDATE_BOOLEAN);

# REGISTER SERVICES

# register logger service provider
$logLevel = \Monolog\Logger::INFO;
if($app['debug']) {
    $logLevel = \Monolog\Logger::DEBUG;
}
$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => __DIR__.'/../logs/log-'.date('Y-m-d').'.log',
    'monolog.name' => 'silexv',
    'monolog.level' => $logLevel
));

$app->extend('monolog', function($monolog, $app) {
    $handler = new \Monolog\Handler\StreamHandler(__DIR__.'/../logs/log-'.date('Y-m-d').'.log');
    $handler->setFormatter(new \Monolog\Formatter\LineFormatter(
        "[%datetime%] %level_name%: %message% %context%\n"
    ));
    $monolog->pushHandler($handler);

    return $monolog;
});

# register security service provider
$app->register(new Silex\Provider\SecurityServiceProvider());

# register validator provider (optional)
$app->register(new Silex\Provider\ValidatorServiceProvider());

# register config service provider for database
$app->register(new Igorw\Silex\ConfigServiceProvider($config_path."/database.php"));

# register config service provider for constants
$app->register(new \Igorw\Silex\ConfigServiceProvider($config_path."/constants.php"));

# register config service provider for doctrine
$app->register(new Silex\Provider\DoctrineServiceProvider());

# register doctrine ORM
$app->register(new \Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider());

# Register errors
$app->error(function (\Exception $e, Request $request, $code) use ($app) {
    $messageArray = array(
        'developer_message' =>  $e->getMessage(),
        'user_message'      =>  'An error has occurred. Please try again.'
    );
    $message = Util::formatErrorHandler($code, "100", $messageArray);
    return $app->json($message, $code);
});
$app['monolog']->info('hello');
# ROUTES
# This can be mounted in many different ways. Improvements later
$app->mount('/', new \App\Routes());

# initialize app in util library to be accessible everywhere
\App\Libraries\Util::initialize($app);
