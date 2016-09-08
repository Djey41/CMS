<?php
/**
 * Created by PhpStorm.
 * User: sapphirehead
 * Date: 22.08.2016
 * Time: 18:37
 */

namespace closed\testmodels;

use models\ListPhotoClass;
use models\Pagination;

class ListPhotoClassTest extends \PHPUnit_Framework_TestCase
{
    public function testGetListPhoto()
    {
        $res = ListPhotoClass::getListPhoto(new Pagination());
        $this->assertTrue(!empty($res));
    }
}
