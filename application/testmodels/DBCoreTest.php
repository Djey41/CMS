<?php
/**
 * Created by PhpStorm.
 * User: sapphirehead
 * Date: 02.08.2016
 * Time: 0:52
 */

namespace application\testmodels;

use models\DBCore;

require_once (__DIR__ . '/../../index.php');

class DBCoreTest extends \PHPUnit_Framework_TestCase
{
    public function testMyQuery()
    {
        $sql = "SELECT * FROM photographs";
        $res = DBCore::myQuery($sql);
        $this->assertTrue(!empty($res));
        $this->assertTrue($res);
    }

    public function testMyFetchArray()
    {
        $res = DBCore::myFetchArray();
        $this->assertTrue(!empty($res));
    }
    public function testNumRows()
    {
        $res = DBCore::numRows();
        $this->assertTrue(!empty($res));
    }
    public function testisertId()
    {
        $res = DBCore::insertId();
        $this->assertTrue(empty($res));
    }
    public function testAffectedRows()
    {
        $res = DBCore::affectedRows();
        $this->assertTrue(!empty($res));
    }
}
