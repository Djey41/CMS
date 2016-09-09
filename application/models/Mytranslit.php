<?php
/**
 * Created by PhpStorm.
 * User: sapphirehead
 * Date: 05.07.2016
 * Time: 23:25
 */

namespace models;

class MyTranslit extends DBObject
{
    /**
     * @staticvar string
     * @access [protected]
     */
    protected static $table_name="translit";
    /**
     * @staticvar array
     * @access [protected]
     */
    protected static $db_fields=['id', 'rus', 'eng'];
    public $id;
    public $rus;
    public $eng;
    private static $tmp_alfabet=[];


    public static function translitFromDB()
    {
        $sql = "SELECT id, rus, eng FROM translit ";

        $alfabet = self::findBySql($sql);
        foreach ($alfabet as $key_arr36 => $to_one) {
            self::$tmp_alfabet[$to_one->rus] = $to_one->eng;
        }
    }
    public static function transliteration($subject)
    {
        $subject = mb_strtolower($subject, 'UTF-8');
        $res_translit = strtr($subject, self::$tmp_alfabet);
        return $res_translit;
    }
}
