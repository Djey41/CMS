<?php
/**
 * Created by PhpStorm.
 * User: sapphirehead
 * Date: 26.07.2016
 * Time: 22:30
 */

namespace application\testmodels;

use models\Comment;
use models\Pagination;

class CommentTest extends \PHPUnit_Framework_TestCase
{
    private $comm;

    public static function setUpBeforeClass()
    {

    }
    public function setUp()
    {
        $this->comm = new Comment();
    }
    protected function tearDown()
    {
        unset($this->comm);
    }
    /**
     *
     * @dataProvider provider
     */
    public function testEmptyReturnFromMake($a, $b, $c)
    {

        $res = $this->comm->make($a, $b, $c);
        $this->assertTrue(!empty($res), "текстовое сообщение в консоль");
        $this->assertInstanceOf(Comment::class, $res);
    }
        public function provider()
    {
        return [
            array(1, 'a', 'b'),
            array(2, 'c', 'd'),
            array(3, 'e', 'f'),
            array(1, 'g', 'h')
        ];
    }
    public function testFindCommentsOn()
    {
        $this->assertTrue(is_array($this->comm->findCommentsOn(2, new Pagination())));
    }
    public function testFindCommentsOnForCurrent()
    {
        $this->assertTrue(is_array($this->comm->findCommentsOnForCurrent(2)));
    }
}
