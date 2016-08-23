<?php
/**
 * Created by PhpStorm.
 * User: sapphirehead
 * Date: 14.08.2016
 * Time: 22:28
 */

namespace closed\testmodels;

use Models\UploadException;
class UploadExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testCodeToMessage()
    {
        $class = new \ReflectionClass(UploadException::class);
        $method = $class->getMethod('codeToMessage');
        $method->setAccessible(true);
        $obj = new UploadException(1);
        //$method->invokeArgs($obj, [[null]]);
        //$this->assertTrue($method->invoke($obj, 0));
        $this->assertEquals("The uploaded file exceeds the upload_max_filesize directive in php.ini", $method->invoke($obj, 1));
    }
}
