<?php
/**
 * Util.php
 * Contains the Util class
 * @author Gabriel John P. Gagno
 * @version 1.0
 * @copyright 2017 Stratpoint Technologies, Inc.
 * @date 2016/12/15
 */
namespace App\Libraries;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class Util
{
    private static $_app;
    public static function initialize(Application $app)
    {
        Util::$_app = $app;
    }

    public static function getApp()
    {
        return Util::$_app;
    }

    public static function env($varName, $defaultValue = NULL)
    {
        if(isset($varName)||!empty($varName)) {
            if(getenv($varName)){
                return getenv($varName);
            }
        }
        return $defaultValue;
    }

    public static function formatSuccessHandler($resultsArray, $metadataArray = null)
    {
        if(!$metadataArray==null) {
            return array(
                'metadata'  =>  $metadataArray,
                'results'   =>  $resultsArray
            );
        }
        return array(
            'result'   =>  $resultsArray
        );


    }

    public static function formatErrorHandler($status_code, $error_code, $messageArray) {
        $message = array(
            "status"    =>  $status_code,
            "developer_message" =>  $messageArray['developer_message'],
            "user_message"  =>  $messageArray['user_message'],
            "error_code"    =>  $error_code
        );

        return $message;
    }

    public static function logStartHandler($requestId, $requestName, $requestParams)
    {
        $app = Util::getApp();
        $logger = $app['monolog'];
        $message = "START ";

        $message = $message."$requestId "."$requestName "."$requestParams";

        $logger->info($message);
    }

    public static function logEndHandler($requestId, $levelName, $message)
    {
        $app = Util::getApp();
        $logger = $app['monolog'];
        $msg = "END ";

        $msg = $message."$requestId $message";

        switch($levelName) {
            case 'error' :
                $logger->error($msg);
                break;
            default:
                $logger->info($msg);
                break;
        }
    }
}
