<?php
/**
 * Created by PhpStorm.
 * User: sapphirehead
 * Date: 19.05.2016
 * Time: 20:35
 */
namespace models;

class Rank extends DBObject
{

    /**
     * @var string
     */
    protected static $table_name="photographs";
    /**
     * @var array
     */
    protected static $db_fields=['id', 'filename', 'prew_name', 'type', 'size', 'caption', 'alt', 'views', 'dt'];
    /**
     * @var integer
     */
    public static $rank;

    /**
     *  Метод ранжировки фото
     * @param int $id
     */
    public static function getRankObj(int $id)
    {
        $sql = "UPDATE photographs ";
        $sql .= "SET views=views+1 ";
        $sql .= "WHERE id = :rank";

        self::$rank = $id;
        $obj_rank = new Rank();
        $obj_rank->myQuery($sql);
        }
}
