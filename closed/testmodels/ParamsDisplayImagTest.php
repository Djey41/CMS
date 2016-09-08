<?php
/**
 * Created by PhpStorm.
 * User: sapphirehead
 * Date: 10.08.2016
 * Time: 20:57
 */

namespace closed\testmodels;


use models\ParamsDisplayImag;

class ParamsDisplayImagTest extends \PHPUnit_Framework_TestCase
{
    private $param_obj;
    public function setUp()
    {
        $this->param_obj = new ParamsDisplayImag();
    }
    public function tearDown()
    {
        unset($this->param_obj);
    }
    /**
     *
     * @dataProvider provider
     */
    public function testMakeParamsQuality($width, $height, $rgb, $quality, $title, $footer,
                                          $name_pages, $count_images, $sort)
    {
        $res = $this->param_obj->makeParamsQuality($width, $height, $rgb, $quality, $title, $footer, $name_pages, $count_images, $sort);
        $this->assertInstanceOf(ParamsDisplayImag::class, $res);// just - 'ParamsDisplayImag' don't work, it need be with ::class
    }
    public function provider()
    {
        return [
            [1, 1, 'c', 1, 'a', 'b', 'e', 'f', 'g'],
            [2, 1, 'c', 1, 'a', 'b', 'e', 'f', 'g'],
            [3, 1, 'c', 1, 'a', 'b', 'e', 'f', 'g'],
            [4, 1, 'c', 1, 'a', 'b', 'e', 'f', 'g']
        ];
    }
}
