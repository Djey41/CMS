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
    public static $clean_id;

    /**
     *  Метод ранжировки фото
     * @param int $id
     */
    public static function getRankObj(int $id)
    {
        $sql = "UPDATE photographs ";
        $sql .= "SET views=views+1 ";
        $sql .= "WHERE id = :id";

        self::$clean_id = $id;
        $obj = new Rank();
        $obj->myQuery($sql);
        $discon  = new DBCore();
        $discon->closeConnection();
    }
}
