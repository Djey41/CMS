<?php
/**
 * Created by PhpStorm.
 * User: sapphirehead
 * Date: 22.08.2016
 * Time: 18:27
 */

namespace Models;


class ListPhotoClass
{
    /**
     * @param $pagin
     * @return array
     */
    public static function getListPhoto($pagin): array
    {
        $sql = "SELECT id, filename, prew_name, type, size, caption, alt, views, dt FROM photographs ";
        $sql .= "ORDER BY dt DESC ";
        $sql .= "LIMIT {$pagin->per_page} ";
        $sql .= "OFFSET {$pagin->offset()}";

        $phot = Photograph::findBySql($sql);
        return $phot;
    }
}
