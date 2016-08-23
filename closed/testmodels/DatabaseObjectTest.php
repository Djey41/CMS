<?php
/**
 * Created by PhpStorm.
 * User: sapphirehead
 * Date: 03.08.2016
 * Time: 0:28
 */

namespace closed\testmodels;

use Models\Photograph;

class DatabaseObjectTest extends \PHPUnit_Framework_TestCase
{
    public function testFindAll()
    {
        $res = Photograph::findAll();
        $this->assertTrue(is_array($res));
    }
    public function testFindById()
    {
        $res = Photograph::findById(2);
        $this->assertTrue(is_object($res));
    }
    public function testFindBySql()
    {
        $sql = "SELECT * FROM photographs WHERE id=2 LIMIT 1";
        $res = Photograph::findBySql($sql);
        $this->assertEquals(true, is_array($res));
    }
    public function testCountAll()
    {
        $res = Photograph::countAll();
        $this->assertTrue(is_numeric($res));
    }

    public function testInstantiate()
    {
        $class = new \ReflectionClass(Photograph::class);
        $method = $class->getMethod('instantiate');
        $method->setAccessible(true);
       $obj = new Photograph();
        $this->assertTrue(is_object($method->invokeArgs($obj, [[null]])));
      }
    public function testHasAttribute()
    {
        $class = new \ReflectionClass(Photograph::class);
        $method = $class->getMethod('hasAttribute');
        $method->setAccessible(true);
        $obj = new Photograph();
        $this->assertTrue($method->invoke($obj, 'id'));
    }
    public function testAttributes()
    {
        $class = new \ReflectionClass(Photograph::class);
        $method = $class->getMethod('attributes');
        $method->setAccessible(true);
        $obj = new Photograph();
        $this->assertTrue(is_array($method->invoke($obj)));
    }
}
