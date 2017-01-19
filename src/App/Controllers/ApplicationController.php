<?php
/**
 * Created by IntelliJ IDEA.
 * User: gjpgagno
 * Date: 12/15/16
 * Time: 2:57 PM
 */

namespace App\Controllers;


use App\Libraries\RestUtils;
use App\Libraries\Util;
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
        $limit = $request->get('limit')!=null?$request->get('limit'):0;
        $offset = $request->get('offset')!=null?$request->get('offset'):0;

        try{
            $all = $this->_app['orm.em']->getRepository('App\Models\Application')->findAll(Query::HYDRATE_ARRAY, $limit, $offset);
        } catch (\Exception $e) {
            return $e->getTraceAsString();
        }

        $metadataArray = array(
            'limit'       =>  $limit,
            'offset'      =>  $offset,
            'count'       =>  count($all)
        );

        $resultsArray = Util::formatSuccessHandler($all, $metadataArray);

        return $this->_app->json($resultsArray);
    }

    public function show($id)
    {
        $app = $this->_app['orm.em']->getRepository('App\Models\Application')->findOne($id, Query::HYDRATE_ARRAY);
        if($app==null) {
            return $this->_app->json(
                array(
                    'error' => 'not found'
                )
            );
        }

        $resultsArray = Util::formatSuccessHandler($app);

        return $this->_app->json($resultsArray);
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
        /*
        $application  = $this->_app['orm.em']->getRepository('App\Models\Application')
            ->findOne($id);

        if($application == null) {
            return $this->_app->json(
                array(
                    'error' =>  'not found'
                )
            );
        }
        */

    }

    public function destroy($id)
    {
        $application  = $this->_app['orm.em']->getRepository('App\Models\Application')
            ->findOne($id);

        if($application == null) {
            return $this->_app->json(
                array(
                    'error' =>  'not found'
                )
            );
        }

        try {
            $this->_app['orm.em']->remove($application);
            $this->_app['orm.em']->flush();
        } catch (\Exception $e) {
            die($e->getMessage());
            return $this->_app->json(array(
                "error" => "error"
            ));
        }

        return $this->_app->json(
            array(
                "delete successful" => "delete"
            )
        );

    }
}