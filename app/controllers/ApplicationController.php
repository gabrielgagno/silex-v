<?php
/**
 * Created by IntelliJ IDEA.
 * User: gjpgagno
 * Date: 12/15/16
 * Time: 2:57 PM
 */

namespace App\Controllers;


use Silex\Application;

class ApplicationController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return 'hi';
    }
}