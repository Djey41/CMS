<?php
use Models\ {
       Session,
       Photograph,
       SmartyClass,
       Pagination,
       ModelsPDOException,
       ModelsException
};

require_once ( "../../initialize.php");

$session = new Session();
$message = $session->message();
if (!$session->isLoggedIn()) { redirectTo("login.php"); }
try {
	if (!empty($_GET['id'])) {
      $photo_id = $_SESSION['photo_id'] = $_GET['id'];
	} elseif (empty($_GET['id'])) {
        $photo_id = $_SESSION['photo_id'];
    } else {
        throw new ModelsException("Неверные параметры выдачи изображения.");
    }

    $one_photo = Photograph::findById($photo_id);
    if (!$one_photo) {
        throw new ModelsException("Изображение не обнаружено.");
    }

    /**
     * Pagination parameters
     */
    $page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;//
    $page = escapeIntValue($page);
    $per_page = 10;
    $total_count = count($one_photo->forGettingOfNumberComments());
    $pagination = new Pagination($page, $per_page, $total_count);
    $comments = $one_photo->comments($pagination);

} catch (ModelsPDOException $e) {
    $session->message($e->getMessage());
    redirectTo("adminindex.php");
} catch (ModelsException $e) {
    $session->message($e->getMessage());
    redirectTo("adminindex.php");
}
/**
 * Block template
 */

$smarty = new SmartyClass();
$smarty->assign('message', $message);
$smarty->assign('photo', $one_photo);
$smarty->assign('comments', $comments);
$smarty->assign('pagination', $pagination);
$smarty->display('C:\OpenServer\domains\photogallery\public\Smartemplates\mytemplates\comments.tpl');