<?php
use Models\ {
       Session,
       Photograph,
       SmartyClass,
       Pagination,
       ModelsPDOException,
        ListPhotoClass
};

require_once ("../../initialize.php");

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

} catch (ModelsPDOException $e) {
    $session->message($e->getMessage());
    redirectTo("adminindex.php");
}
/**
 * Block template
 */

$smarty = new SmartyClass();
$smarty->assign('message', $message);
$smarty->assign('photos', $photos);
$smarty->assign('pagination', $pagination);
$smarty->display('C:\OpenServer\domains\photogallery\public\Smartemplates\mytemplates\list_photos.tpl');