<?php
/**
 * Created by PhpStorm.
 * User: sapphirehead
 * Date: 03.05.2016
 * Time: 20:51
 */
use Models\ {
       Session,
       Photograph,
       SmartyClass,
       ModelsPDOException,
       ModelsException,
       MyTranslit
};

require_once ("../../initialize.php");

$session = new Session();
if (!$session->isLoggedIn()) { redirectTo("login.php"); }
try {
 if (empty($_GET['id'])) {
    throw new ModelsException("ID фотографии не был обнаружен.");
}

    $photoup = Photograph::findById(escapeIntValue($_GET['id']));
    if (!$photoup) {
        throw new ModelsException("Изображение {$photoup->filename} не было найдено.");
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $photoup->caption = escapeValue($_POST['caption']);
        if (preg_match('/[^a-zA-Zа-яА-ЯёЁ0-9\s]+/u', $photo->caption)) {
            throw new ModelsException("Для названия возоможен выбор любых букв и цифр (без учёта регистра, без 
            спецсимволов)");
        }
        $alt = escapeValue($_POST['alt']);
        if (preg_match('/[^a-zA-Zа-яА-ЯёЁ0-9_\s]+/u', $alt)) {
            throw new ModelsException("Для тега возоможен выбор любых (кириллица автоматически транслитерируется) букв 
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
} catch (ModelsPDOException $e) {
    $session->message($e->getMessage());
    redirectTo("adminindex.php");
} catch (ModelsException $e) {
    $session->message($e->getMessage());
    redirectTo("list_photos.php");
}
/**
 * Block template
 */

$smarty = new SmartyClass();
$smarty->assign('photoup', $photoup);
$smarty->display('C:\OpenServer\domains\photogallery\public\Smartemplates\mytemplates\update_photoinfo.tpl');
