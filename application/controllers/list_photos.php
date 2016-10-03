<?php
use models\ {
       Session,
       Photograph,
       SmartyClass,
       Pagination,
       ExeptionPDOMy,
        ExeptionMy,
       ListPhotoClass
};

require_once("../../index.php");

$session = new Session();
$message = $session->message();
if (!$session->isLoggedIn()) { redirectTo("login.php"); }

/**
 * Pagination parameters
 */
try {
    $page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
    $per_page = 10;
    $total_count = Photograph::countAll();
    $pagination = new Pagination($page, $per_page, $total_count);
    $photos = ListPhotoClass::getListPhoto($pagination);

} catch (ExeptionPDOMy $e) {
    $session->message("Error on the {$e->getLine()}-lines. Info about:\n{$e->getMessage()}.\nPath: {$e->getFile()}\n\n");
    redirectTo("adminindex.php");
} catch (ExeptionMy $e) {
    $session->message($e->getMessage());
    redirectTo("list_photos.php");
}
/**
 * Block template
 */

$smarty = new SmartyClass();
$smarty->assign('message', $message);
$smarty->assign('photos', $photos);
$smarty->assign('pagination', $pagination);
$smarty->display('C:\OpenServer\domains\photogallery\application\smartemplates\list_photos.tpl');
