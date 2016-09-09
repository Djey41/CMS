<?php
/**
 * Created by PhpStorm.
 * User: sapphirehead
 * Date: 14.08.2016
 * Time: 22:28
 */

namespace application\testmodels;

use models\ExeptionUploadMy;
class ExceptionUploadMyTest extends \PHPUnit_Framework_TestCase
{
    public function testCodeToMessage()
    {
        $class = new \ReflectionClass(ExeptionUploadMy::class);
        $method = $class->getMethod('codeToMessage');
        $method->setAccessible(true);
        $obj = new ExeptionUploadMy(1);
        //$method->invokeArgs($obj, [[null]]);
        //$this->assertTrue($method->invoke($obj, 0));
        $this->assertEquals("Размер загружаемого файла превышает значение директивы upload_max_filesize в php.ini", $method->invoke($obj, 1));
    }
}
