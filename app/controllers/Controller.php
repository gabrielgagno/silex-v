<?php
/**
 * Created by IntelliJ IDEA.
 * User: gjpgagno
 * Date: 12/15/16
 * Time: 3:03 PM
 */

namespace App\Controllers;


use App\Libraries\Util;
use Silex\Application;

abstract class Controller
{
    protected $_app;
    protected $_logger;

    public function __construct()
    {
        $this->_app = Util::getApp();
        $this->_logger = $this->_app['monolog'];
    }
}