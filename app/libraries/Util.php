<?php

/**
 * Created by IntelliJ IDEA.
 * User: gjpgagno
 * Date: 12/15/16
 * Time: 2:37 PM
 */

namespace App\Libraries;

use Silex\Application;

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
}