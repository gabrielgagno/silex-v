<?php
/**
 * Created by IntelliJ IDEA.
 * User: gjpgagno
 * Date: 12/15/16
 * Time: 2:57 PM
 */

namespace App\Controllers;


use Silex\Application;

class ApplicationController
{
    public function index(Application $app)
    {
        return 'hi';
    }
}