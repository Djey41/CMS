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
            $this->template_dir = 'mytemplates/';
            $this->compile_dir  = 'mytemplates_c/';
            $this->config_dir   = 'myconfigs/';
            $this->cache_dir    = 'mycache/';
            //$this->error_reporting = E_ALL; // LEAVE E_ALL DURING DEVELOPMENT
        }
}
