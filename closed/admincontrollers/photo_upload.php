<?php
use models\ {
       Session,
       Photograph,
       SmartyClass,
       ExeptionUploadMy,
       ExeptionMy,
       MyTranslit
};

require_once('../../index.php');

$session = new Session();
$message = $session->message();
if (!$session->isLoggedIn()) { redirectTo("login.php"); }

	$max_file_size = 1048576;
try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $photo = new Photograph();
        $photo->caption = escapeValue($_POST['caption']);
        if (preg_match('/[^a-zA-Zа-яА-ЯёЁ0-9\s]+/u', $photo->caption)) {
            throw new ExeptionMy("Для названия возоможен выбор любых букв и цифр (без учёта регистра, без 
            спецсимволов)");
        }
        $alt = escapeValue($_POST['alt']);
        if (preg_match('/[^a-zA-Zа-яА-ЯёЁ0-9\s]+/u', $alt)) {
            throw new ExeptionMy("Для тега возоможен выбор любых (кириллица автоматически транслитерируется) 
            букв и цифр (без учёта регистра, без спецсимволов)");
        } else {
            MyTranslit::translitFromDB();
            $translit_alt = MyTranslit::transliteration($alt);
            $photo->alt = $translit_alt;
        }
        $photo->dt = date("Y-m-d H:i:s");
        $photo->attachFile($_FILES['file_upload']);
        $photo->save();
        redirectTo('list_photos.php');
     }
} catch (ExeptionMy $e) {
    $session->message($e->getMessage());
    redirectTo('photo_upload.php');
} catch (ExeptionUploadMy $e) {
    $session->message($e->getMessage());
    redirectTo('photo_upload.php');
}

/**
 * Block output template
 */

$smarty = new SmartyClass();
$smarty->assign('max_file_size', $max_file_size);
$smarty->assign('message', $message);
$smarty->display('C:\OpenServer\domains\photogallery\public\Smartemplates\mytemplates\photo_upload.tpl');
