<?php
/**
 * Created by PhpStorm.
 * User: sapphirehead
 * Date: 14.08.2016
 * Time: 20:48
 */

namespace closed\testmodels;

use models\Session;
use models\User;
class SessionTest extends \PHPUnit_Framework_TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = $this->createMock(Session::class);
        $this->assertInstanceOf(Session::class, $this->stub);
    }
    public function tearDown()
    {
        unset($this->stub);
    }

    public function testIsLoggedIn()
    {
        $this->stub->method('isLoggedIn')
            ->willReturn(false);
        $this->assertFalse($this->stub->isLoggedIn());
    }


    public function testLogin()
    {
        $this->stub->method('login')
            ->willReturn(true);
        $this->assertTrue($this->stub->login(new User));
    }
    public function testMessage()
    {
        $this->stub->method('message')
            ->willReturn(null);
        $this->assertNull($this->stub->message('Test string message\'s function'));

    }
}
