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
            return getenv($varName);
        }
        return $defaultValue;
    }

    public static function formatErrorHandler(\Exception $e, Request $request, $code) {
        $message = array();
        switch($code) {
            case 404:
                $message = array(
                    'error'         =>  '404 Not Found',
                    'code'          =>  $code,
                    'description'   =>  $e->getMessage()
                );
                break;
            default:
                $message = array(
                    'error'         =>  '500 Internal Server Error',
                    'code'          =>  $code,
                    'description'   =>  $e->getMessage()
                );
                break;
        }

        return $message;
    }
}