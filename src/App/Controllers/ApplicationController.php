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
        $all = $this->_app['orm.em']->getRepository('App\Models\Application')->findAll(null, null, Query::HYDRATE_ARRAY);

        return $this->_app->json(array(
            'result' => 'success',
            'message' => $all
        ));
    }

    public function show($id)
    {
        $app = $this->_app['orm.em']->getRepository('App\Models\Application')->findAll(null, null, Query::HYDRATE_ARRAY);

        if($app==null) {

        }

        return $this->_app->json(array(
            'result' => 'success',
            'message' => $app
        ));
    }

    public function create(Request $request)
    {
        $application = new Application;
        $application->setCode($request->get('code'));
        $application->setName($request->get('name'));
        try {
            $this->_app['orm.em']->persist($application);
            $response = $this->_app['orm.em']->flush();
        } catch (\Exception $e) {
            return $this->_app->json(
                array(
                    "error" => "error"
                )
            );
        }
        return $this->_app->json(
            array(
                "please wait" => "wait"
            )
        );
    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {

    }
}