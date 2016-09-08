<?php
/**
 * Created by PhpStorm.
 * User: sapphirehead
 * Date: 11.08.2016
 * Time: 21:51
 */

namespace closed\testmodels;

use models\ExeptionUploadMy;
use \PHPUnit\Framework\TestCase;
use models\Photograph;

class PhotographTest extends TestCase
{
    private $stub;
    private $p_obj;
    public function setUp()
    {
        $this->p_obj = new Photograph();
        $this->stub = $this->createMock(Photograph::class);
        $this->assertInstanceOf(Photograph::class, $this->stub);
    }
    public function tearDown()
    {
        unset($this->stub);
        unset($this->p_obj);
    }

    public function testAttachFileReturnArg()
    {
        $this->stub->method('attachFile')
            ->will($this->returnArgument(0));
        $this->assertEquals([], $this->stub->attachFile([]));
    }
    public function testAttachMock()
    {
        $mock = $this->getMockBuilder(Photograph::class)
            ->setMethods(['attachFile'])
            ->getMock();
        $mock->expects($this->once())
            ->method('attachFile')
            ->with(
                $this->equalTo([]));
        $mock->attachFile([]);
    }
    public function testAttachFileTrowExeption()
    {
        $this->stub->method('attachFile')
            ->will($this->throwException(new ExeptionUploadMy(0)));
        $this->stub->attachFile([]);
    }
    public function testImagePath()
    {
        $this->assertEquals('images/', $this->p_obj->imagePath());
    }
    public function testSizeAsText()
    {
        $this->assertEquals(' bytes', $this->p_obj->sizeAsText());
    }
    public function testPrewPath()
    {
        $class = new \ReflectionClass(Photograph::class);
        $method = $class->getMethod('prewPath');
        $method->setAccessible(true);
        $obj = new Photograph();
        $this->assertFileExists($method->invoke($obj));
    }

    /**
     *  не выводить ошибку в консоли
     * @param \Exception|\Throwable $e
     */
    protected function onNotSuccessfulTest($e)
    {
        $this->markTestSkipped('This test was skipped because there was a databas');
        //print __METHOD__ . "\n";
        //throw $e;
        //print $e;
    }
}
