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

    public static function formatSuccessHandler($resultsArray, $metadataArray = null)
    {
        if(!$metadataArray==null) {
            return array(
                'metadata'  =>  $metadataArray,
                'results'   =>  $resultsArray['result']
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
}