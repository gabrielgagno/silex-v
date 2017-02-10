<?php
/**
 * Created by IntelliJ IDEA.
 * User: gjpgagno
 * Date: 1/30/17
 * Time: 4:49 PM
 */

namespace App\Tests;

use App\Libraries\Util;

class UtilTest extends \PHPUnit_Framework_TestCase
{
    public function testformatErrorHandler()
    {
      $messageArray = array(
        'developer_message' => 'This is a test developer_message',
        'user_message' => 'This is a test user_message',

      );
      $response = Util::formatErrorHandler(404 , 10 , $messageArray);

      $this->assertArrayHasKey('status',$response);
      $this->assertArrayHasKey('error_code',$response);
      $this->assertArrayHasKey('developer_message',$response);
      $this->assertArrayHasKey('user_message',$response);
      $this->assertEquals(404, $response['status']);
      $this->assertEquals(10,$response['error_code']);
      $this->assertEquals('This is a test developer_message',$response['developer_message']);
      $this->assertEquals('This is a test user_message',$response['user_message']);

    }

    public function testformatSuccessHandler()
    {
      $messageArray = array(
        'developer_message' => 'This is a test developer_message',
        'user_message' => 'This is a test user_message',

      );
      $response = Util::formatErrorHandler(404 , 10 , $messageArray);
      $this->assertArrayHasKey('status',$response);
      $this->assertArrayHasKey('error_code',$response);
      $this->assertArrayHasKey('developer_message',$response);
      $this->assertArrayHasKey('user_message',$response);
      $this->assertEquals(404, $response['status']);
      $this->assertEquals(10,$response['error_code']);
      $this->assertEquals('This is a test developer_message',$response['developer_message']);
      $this->assertEquals('This is a test user_message',$response['user_message']);

    }

}
