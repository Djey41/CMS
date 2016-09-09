<?php
/**
 * Created by PhpStorm.
 * User: sapphirehead
 * Date: 14.08.2016
 * Time: 22:41
 */

namespace application\testmodels;


use models\User;

class UserTest extends \PHPUnit_Framework_TestCase
{
    private $stub;
    private $user;

    public function setUp()
    {
        $this->user = new User();
        $this->stub = $this->createMock(User::class);
        $this->assertInstanceOf(User::class, $this->stub);
    }
    public function tearDown()
    {
        unset($this->user);
    }

    public function testGetUserPropertys()
    {
        $this->assertInstanceOf(User::class, $this->user->getUserPropertys('admin', '1234', 'Jo', 'By'));
    }
    public function testFullName()
    {
        $this->assertEquals(null, $this->user->fullName());
    }
    public function testGetAuthenticFromBD()
    {
        $this->stub->method('getAuthenticFromBD')
            ->will($this->returnArgument(0));
        $this->assertEquals('admin', $this->stub->getAuthenticFromBd('admin', '1234', 'OR'));
    }
}
