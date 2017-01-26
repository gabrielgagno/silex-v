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

class ApplicationController extends BaseController
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
            return $e->getMessage();
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
            $messageArray = array(
                'developer_message' =>  "Resource not found",
                'user_message'      =>  "The resource you were looking for does not exist."
            );
            $errorMessage = Util::formatErrorHandler(404, "99", $messageArray);
            return $this->_app->json($errorMessage, 404);
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

      $record = $this->_app['orm.em']->getRepository('App\Models\Application')->findOne($id, Query::HYDRATE_ARRAY);
      if($record==null) {
      $messageArray = array(
              'developer_message' =>  "Resource not found",
              'user_message'      =>  "The resource you were looking for does not exist."
          );
          $errorMessage = Util::formatErrorHandler(404, "99", $messageArray);
          return $this->_app->json($errorMessage, 404);
      }

      $application = new Application;
      $application->set(array("code" => "Code","name" => "Name"));
      $this->_app['orm.em']->persist($application);
      $this->_app['orm.em']->flush();

      $record = $this->_app['orm.em']->getRepository('App\Models\Application')->findOne($id, Query::HYDRATE_ARRAY);

      $resultsArray = Util::formatSuccessHandler($record);

       return $this->_app->json($resultsArray);

    }

    public function destroy($id)
    {
        $application  = $this->_app['orm.em']->getRepository('App\Models\Application')
            ->findOne($id);

        if($application==null) {
            $messageArray = array(
                'developer_message' =>  "Resource not found",
                'user_message'      =>  "The resource you were looking for does not exist."
            );
            $errorMessage = Util::formatErrorHandler(404, "99", $messageArray);
            return $this->_app->json($errorMessage, 404);
        }

        try {
            $this->_app['orm.em']->remove($application);
            $this->_app['orm.em']->flush();
        } catch (\Exception $e) {
            $messageArray = array(
                'developer_message' =>  $e->getMessage(),
                'user_message'      =>  "A database error has occurred."
            );
            $errorMessage = Util::formatErrorHandler(500, "100", $messageArray);
            return $this->_app->json($errorMessage, 500);
        }

        return $this->_app->json(
            Util::formatSuccessHandler("Successfully deleted the resource.")
        );

    }
}
