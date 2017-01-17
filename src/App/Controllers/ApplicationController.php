<?php
/**
 * Created by IntelliJ IDEA.
 * User: gjpgagno
 * Date: 12/15/16
 * Time: 2:57 PM
 */

namespace App\Controllers;


use App\Libraries\RestUtils;
use Doctrine\ORM\Query;
use App\Models\Application;
use Symfony\Component\HttpFoundation\Request;

class ApplicationController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request)
    {
        $app = new Application('Application');
        $all = Application::getAll();
/*
        $applicationRepository = $this->_app['orm.em']->getRepository('App\Models\Application');
        $applications = $applicationRepository->findAll(Query::HYDRATE_SCALAR);
        $result = array();
        foreach($applications as $application) {
            //die(var_dump($application));
            $result[] = $application->getApplication();
        }*/
        foreach($all as $a) {
            //die(var_dump($application));
            $a->arrayForm();
        }
        return $this->_app->json(array(
            'result' => 'success',
            //'message' => $result
        ));
    }
}