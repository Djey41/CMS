<?php
/**
 * Created by PhpStorm.
 * User: sapphirehead
 * Date: 09.08.2016
 * Time: 1:28
 */

namespace closed\testmodels;

use Models\MyTranslit;

class MyTranslitTest extends \PHPUnit_Framework_TestCase
{
   public function getPropertyTranslitFromDB()
    {
        $reflector = new \ReflectionClass('MyTranslit');
        $reflector_property = $reflector->getProperty('tmp_alfabet');
        $reflector_property->setAccessible(true);
        $tmp = $reflector_property->getValue(new MyTranslit);

    }
    /**
     * @depends getPropertyTranslitFromDB
     */
    public function testTranslitFromDB($tmp)
    {
        $this->assertTrue($tmp);
    }
    public function testTransliteration()
    {
        $res = MyTranslit::transliteration('CoT BegemoT');
        $this->assertEquals('cot begemot', $res);
    }
}
