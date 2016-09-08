<?php
/**
 * Created by PhpStorm.
 * User: sapphirehead
 * Date: 29.04.2016
 * Time: 18:41
 */
use models\ {
       Session,
       ParamsDisplayImag,
       ExeptionPDOMy,
       ExeptionMy,
       SmartyClass
};

require_once("../../index.php");

$session = new Session();
$message = $session->message();
if (!$session->isLoggedIn()) { redirectTo("login.php"); }
try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $width = escapeIntValue($_POST['width']);
        $height = escapeIntValue($_POST['height']);

        $quality = escapeIntValue($_POST['quality']);
        $title = escapeValue($_POST['title']);
        $footer = escapeValue($_POST['footer']);
        $name_pages = escapeValue($_POST['name_pages']);
        $count_images = escapeIntValue($_POST['count_images']);
        $sort = escapeValue($_POST['sort']);
        $rgb = escapeValue($_POST['rgb']);
        $rgb_hex = getCodeColor($rgb);
        $params_obj = new ParamsDisplayImag;
        if (empty($count_images)) {
            $count_images = 15;
        }
        $params = $params_obj->makeParamsQuality($width, $height, $rgb_hex, $quality, $title, $footer, $name_pages,
        $count_images, $sort);
        $params->saveDB();
         redirectTo("adminindex.php");

    } else {
        $params = new ParamsDisplayImag();
        $params->width = 200;
        $params->height = 160;
        $params->rgb = "white";
        $params->quality = 100;
        $params->title = "Photogallery";
        $params->footer = "Group";
        $params->name_pages = "Photos";
        $params->count_images = 15;
        //$sort = "views";
    }
} catch (ExeptionPDOMy $e) {
    $session->message($e->getMessage());
    redirectTo("adminindex.php");
} catch (ExeptionMy $e) {
    $session->message($e->getMessage());
    redirectTo("display_settings.php");
}
/**
 * Block template
 */

$smarty = new SmartyClass();
$smarty->assign('params', $params);
$smarty->assign('message', $message);
$smarty->display('C:\OpenServer\domains\photogallery\closed\smartemplates\display_settings.tpl');
