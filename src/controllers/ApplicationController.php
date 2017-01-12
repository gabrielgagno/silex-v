<?php
/**
 * Created by IntelliJ IDEA.
 * User: gjpgagno
 * Date: 12/15/16
 * Time: 2:57 PM
 */

namespace App\Controllers;


use App\Libraries\RestUtils;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class ApplicationController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request)
    {
        $rawResponse = RestUtils::requestHandler($this->_logger, $request, 'http://localhost:3000/applications', __FUNCTION__);
        $response = RestUtils::responseHandler($this->_logger, $rawResponse->code, $rawResponse);
        return $response;
    }
}