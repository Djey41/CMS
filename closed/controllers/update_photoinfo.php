<?php
/**
 * Created by PhpStorm.
 * User: sapphirehead
 * Date: 03.05.2016
 * Time: 20:51
 */
use models\ {
       Session,
       Photograph,
       SmartyClass,
       ExeptionPDOMy,
       ExeptionMy,
       MyTranslit
};

require_once("../../index.php");

$session = new Session();
if (!$session->isLoggedIn()) { redirectTo("login.php"); }
try {
 if (empty($_GET['id'])) {
    throw new ExeptionMy("ID фотографии не был обнаружен.");
}

    $photoup = Photograph::findById(escapeIntValue($_GET['id']));
    if (!$photoup) {
        throw new ExeptionMy("Изображение {$photoup->filename} не было найдено.");
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $photoup->caption = escapeValue($_POST['caption']);
        if (preg_match('/[^a-zA-Zа-яА-ЯёЁ0-9\s]+/u', $photo->caption)) {
            throw new ExeptionMy("Для названия возоможен выбор любых букв и цифр (без учёта регистра, без 
            спецсимволов)");
        }
        $alt = escapeValue($_POST['alt']);
        if (preg_match('/[^a-zA-Zа-яА-ЯёЁ0-9_\s]+/u', $alt)) {
            throw new ExeptionMy("Для тега возоможен выбор любых (кириллица автоматически транслитерируется) букв 
            и цифр (без учёта регистра, без спецсимволов)");
        } else {
            MyTranslit::translitFromDB();
            $translit_alt = MyTranslit::transliteration($alt);
            $photoup->alt = $translit_alt;
        }
        $photoup->saveDB();
        redirectTo("list_photos.php");
    } else {
        $caption = "";
        $alt = "";
    }
} catch (ExeptionPDOMy $e) {
    $session->message($e->getMessage());
    redirectTo("adminindex.php");
} catch (ExeptionMy $e) {
    $session->message($e->getMessage());
    redirectTo("list_photos.php");
}
/**
 * Block template
 */

$smarty = new SmartyClass();
$smarty->assign('photoup', $photoup);
$smarty->display('C:\OpenServer\domains\photogallery\smartemplates\update_photoinfo.tpl');
