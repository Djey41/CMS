<?php
/**
 * Created by PhpStorm.
 * User: sapphirehead
 * Date: 13.03.2016
 * Time: 0:22
 */
namespace models;

// загружаем библиотеку Smarty
    require(__DIR__ . '/../../vendor/smarty/smarty/libs/Smarty.class.php');

/**
 * Class Smartyclass
 * @package models
 */
class SmartyClass extends \Smarty
{
        public function __construct()
        {
            parent::__construct();
            $this->template_dir = 'C:\OpenServer\domains\photogallery\closed\smartemplates\\';
            $this->compile_dir  = 'C:\OpenServer\domains\photogallery\closed\smartemplates\smartemplates_c\\';
            $this->config_dir   = 'C:\OpenServer\domains\photogallery\closed\smartemplates\smartconfig\\';
            $this->cache_dir    = 'C:\OpenServer\domains\photogallery\closed\smartemplates\smartcashe\\';
            //$this->error_reporting = E_ALL; // LEAVE E_ALL DURING DEVELOPMENT
        }
}
