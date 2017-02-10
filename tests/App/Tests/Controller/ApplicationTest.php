<?php
/**
 * Created by IntelliJ IDEA.
 * User: gjpgagno
 * Date: 1/30/17
 * Time: 4:49 PM
 */

namespace App\Tests;
use Symfony\Component\HttpFoundation\Response;
use Unirest\Request as UnirestRequest;


class ApplicationTest extends \PHPUnit_Framework_TestCase
{
    public function testIndex()
    {
        $response = UnirestRequest::get("http://localhost:8001/applications/",
                            $headers = array(), $parameters = null);
        $this->assertObjectHasAttribute('metadata',$response->body);
        $this->assertObjectHasAttribute('results',$response->body);

    }

    public function testShow()
    {
      $response = UnirestRequest::get("http://localhost:8001/applications/1",
                          $headers = array(), $parameters = null);
        $this->assertObjectHasAttribute('result',$response->body);
        $this->assertNotEmpty($response->body->result->id);
        $this->assertNotEmpty($response->body->result->code);
        $this->assertNotEmpty($response->body->result->name);

    }
    public function testCreate()
    {


    }

    public function testUpdate()
    {

    }

    public function testDestroy()
    {

    }
}
