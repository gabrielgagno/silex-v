<?php
/**
 * RestUtils.php
 * Contains the P2MEWrapper class
 * @author Gabriel John P. Gagno
 * @version 1.0
 * @copyright 2016 Stratpoint Technologies, Inc.
 * @date 2016/12/15
 */

namespace App\Libraries;


use Silex\Application;
use Symfony\Component\HttpFoundation\Response;
use Unirest\Request as UnirestRequest;

class RestUtils
{
    /**
     * Formats, formalizes, and logs requests sent to P2ME API
     * @param $logger
     * @param $request
     * @param $url
     * @param $functionName
     * @return \Unirest\Response
     */
    public static function requestHandler($logger, $request, $url, $functionName)
    {
        $xId = sha1($functionName);
        $logger->addInfo("REQUEST ".$url." ".$xId." ".json_encode($request->request->all()));
        return UnirestRequest::get($url, array('x-id' => $xId), json_encode($request->request->all()));
    }

    /**
     * Formats, formalizes, and logs responses received from P2ME API
     * @param $logger
     * @param $code
     * @param null $p2meResponse
     * @return Response
     */
    public static function responseHandler($logger, $code, $p2meResponse = null)
    {
        $status = "fail";
        $message = null; // TODO replace all messages with simple p2meResponse->body later

        # This switch case handles responses sent by the P2ME API. Since the P2ME API does not send
        # exceptions whenever there are errors on its side (Internal Server errors are only sent as
        # is and will not trigger any exception on the middleware's part), it should be handled by
        # looking at the response code it sent and modify the response accordingly.
        switch($code) {
            case 201:
                $message = "No Content";
                $status = "success";
                break;
            case 200:
                $message = $p2meResponse->body;
                $status = "success";
                break;
            case 400:
                $message = "Bad Request";
                break;
            case 401:
                $message = "Unauthorized";
                break;
            case 403:
                $message = "Forbidden";
                break;
            case 404:
                $message = "Not Found";
                break;
            case 500:
                $message = "Internal Server Error";
                break;
            case 502:
                $message = "Bad Gateway";
                break;
            case 503:
                $message = "Service Unavailable";
                break;
        }
        $response = array(
            "status"        => $status,
            "timestamp"     => date("Y-m-d H:i:s"),
            "result"   => $message
        );
        $logger->addInfo("RESPONSE ".$code." ".json_encode($message));
        return new Response(
            json_encode($response),
            $code,
            array(
                'Content-type'  => 'application/json'
            )
        );
    }
}