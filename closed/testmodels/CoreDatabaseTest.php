<?php
/**
 * Created by PhpStorm.
 * User: sapphirehead
 * Date: 02.08.2016
 * Time: 0:52
 */

namespace closed\testmodels;

use Models\CoreDatabase;

require_once (__DIR__.'/../../initialize.php');

class CoreDatabaseTest extends \PHPUnit_Framework_TestCase
{
    public function testMyQuery()
    {
        $sql = "SELECT * FROM photographs";
        $res = CoreDatabase::myQuery($sql);
        $this->assertTrue(!empty($res));
        $this->assertTrue($res);
    }

    public function testMyFetchArray()
    {
        $res = CoreDatabase::myFetchArray();
        $this->assertTrue(!empty($res));
    }
    public function testNumRows()
    {
        $res = CoreDatabase::numRows();
        $this->assertTrue(!empty($res));
    }
    public function testisertId()
    {
        $res = CoreDatabase::insertId();
        $this->assertTrue(empty($res));
    }
    public function testAffectedRows()
    {
        $res = CoreDatabase::affectedRows();
        $this->assertTrue(!empty($res));
    }
}
