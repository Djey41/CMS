<?php
/**
 * Created by PhpStorm.
 * User: sapphirehead
 * Date: 14.08.2016
 * Time: 19:25
 */

namespace closed\testmodels;

use models\Pagination;
use models\SearchModel;
use \PHPUnit\Framework\TestCase;

class SearchModelTest extends TestCase
{
    private $s_obj;
    private $stub;
    public function setUP()
    {
        $this->s_obj = new SearchModel();
        $this->stub = $this->createMock(SearchModel::class);
        $this->assertInstanceOf(SearchModel::class, $this->stub);
    }
    public function tearDown()
    {
        unset($this->s_obj);
        unset($this->stub);
    }

    public function testGetCountForSearch()
    {
        $this->stub->method('getCountForSearch')
            ->willReturn(11);
        $this->assertEquals(11, $this->stub->getCountForSearch('cat'));
        $this->assertLessThanOrEqual($this->stub->getCountForSearch('cat'), 11);
        $this->assertTrue(is_numeric($this->stub->getCountForSearch('cat')));
    }

    public function testSearch()
    {
        $this->stub->method('Search')
            ->willReturn([]);
        $this->assertEquals([], $this->stub->Search(new Pagination()));
        $this->assertTrue(is_array($this->stub->Search(new Pagination())));
    }
}
