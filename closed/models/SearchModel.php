<?php
/**
 * Created by PhpStorm.
 * User: sapphirehead
 * Date: 14.08.2016
 * Time: 17:24
 */

namespace Models;
/**
 * Class SearchModel
 * @package Models
 */
class SearchModel extends Photograph
{

    /**
     * @var string
     */
    public static $se;

    /**
     * @param string $se
     * @return integer
     */
    public function getCountForSearch(string $se): int
    {
        // Вызов предварительной функции для выяснения кол-ва записей для пагинации по количеству найденного
        self::$se = $se;
        $sql = "SELECT id, filename, prew_name, type, size, caption, alt, views, dt FROM " . self::$table_name;
        $sql .= " WHERE caption LIKE :se";
        self::findBySql($sql);
        $total_count = self::affectedRows();
        return $total_count;
    }

    /**
     * @param $pagination
     * @return array
     */
    public function search(Pagination $pagination): array
    {
        $sql = "SELECT id, filename, prew_name, type, size, caption, alt, views, dt FROM " . self::$table_name;
        $sql .= " WHERE caption LIKE :se ";
        $sql .= "ORDER BY views DESC ";
        $sql .= "LIMIT {$pagination->per_page} ";
        $sql .= "OFFSET {$pagination->offset()}";
        $search_photos = self::findBySql($sql);
        return $search_photos;
    }

}