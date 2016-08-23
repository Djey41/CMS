<?php
/**
 * Created by PhpStorm.
 * User: sapphirehead
 * Date: 09.08.2016
 * Time: 21:21
 */

namespace closed\testmodels;

use Models\Pagination;
class PaginationTest extends \PHPUnit_Framework_TestCase
{
    private $pag_obj;
    public function setUp()
    {
        $this->pag_obj = new Pagination();
    }
    public function tearDown()
    {
        unset($this->pag_obj);
    }
    public function testOffset()
    {
        $this->assertEquals(null, $this->pag_obj->offset());

    }
    public function testTotalPages()
    {
        $this->assertEquals(null, $this->pag_obj->totalPages());
    }
    public function testPreviousPage()
    {
        $this->assertEquals(null, $this->pag_obj->previousPage());
    }
    public function testNextPage()
    {
        $this->assertGreaterThanOrEqual($this->pag_obj->nextPage(), 2);
    }
    public function testHasPreviousPage()
    {
        $this->assertFalse($this->pag_obj->hasPreviousPage());
    }
    public function testHasNextPage()
    {
        $this->assertFalse($this->pag_obj->hasNextPage());
    }
}
