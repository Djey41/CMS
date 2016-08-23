<?php
/**
 * Created by PhpStorm.
 * User: sapphirehead
 * Date: 13.03.2016
 * Time: 0:22
 */
namespace Models;

// загружаем библиотеку Smarty
    require(__DIR__ . '/../../vendor/smarty/smarty/libs/Smarty.class.php');

/**
 * Class Smartyclass
 * @package Models
 */
class SmartyClass extends \Smarty
{
        public function __construct()
        {
            parent::__construct();// это тоже работает: $this->__construct() и это: Smarty::__construct();
            $this->template_dir = 'mytemplates/';
            $this->compile_dir  = 'mytemplates_c/';
            $this->config_dir   = 'myconfigs/';
            $this->cache_dir    = 'mycache/';

            //$this->caching = true;// по умолчанию кэширование выключено
            $this->debugging = false;// если true будет выводиться окно консоли дебаггера Смарти при выводе всех шаблонов
            // $this->cache_lifetime = 120;
            //$this->compile_check = true;
            //$this->force_compile = true;
            //$tpl = $this->fetch('Exempl.tpl');echo $tpl;
            //print_r($this->get_temlpate_vars());
            //if($this->templateExists('footer.tpl')) echo "Yes";
            $this->error_reporting = E_ALL; // LEAVE E_ALL DURING DEVELOPMENT
        }
}