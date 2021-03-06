<?php
/**
 * Created by PhpStorm.
 * User: sapphirehead
 * Date: 29.04.2016
 * Time: 21:50
 */
namespace models;

/**
 * Class ParamsDisplayImag
 * @package models
 */
class ParamsDisplayImag extends DBObject
{

    /**
     * @var string
     */
    protected static $table_name="parameters";
    /**
     * @var array
     */
    protected static $db_fields= ['id', 'width', 'height', 'rgb', 'quality', 'title', 'footer', 'name_pages', 'count_images', 'sort'];
    /**
     * @var integer
     */
    public $width;
    /**
     * @var integer
     */
    public $height;
    /**
     * @var integer
     */
    public $rgb;
    /**
     * @var integer
     */
    public $quality;
    /**
     * @var
     */
    public $title;
    /**
     * @var
     */
    public $footer;
    /**
     * @var
     */
    public $name_pages;
    /**
     * @var
     */
    public $count_images;
    /**
     * @var
     */
    public $sort;

    /**
     * @param int $width
     * @param int $height
     * @param int $rgb
     * @param int $quality
     * @param string $title
     * @param string $footer
     * @param string $name_pages
     * @param string $count_images
     * @param string $sort
     * @return ParamsDisplayImag
     * @throws ExeptionMy
     */
    public function makeParamsQuality(int $width, int $height, int $rgb, int $quality, string $title, string $footer,
                                      string $name_pages, string $count_images, string $sort): ParamsDisplayImag
    {
        if (!empty($width) && !empty($height) && !is_null($rgb) && !empty($quality)) {

            $params = new ParamsDisplayImag();
            $params->id = 0;
            $params->width = $width;
            $params->height = $height;
            $params->rgb = $rgb;
            $params->quality = $quality;
            $params->title = $title;
            $params->footer = $footer;
            $params->name_pages = $name_pages;
            $params->count_images = $count_images;
            $params->sort = $sort;
            return $params;
        } else {
            throw new ExeptionMy("Заполните все поля с параметрами отображения галлереи изображений.");
        }
    }
}
