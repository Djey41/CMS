<?php
/**
 * Created by PhpStorm.
 * User: sapphirehead
 * Date: 01.06.2016
 * Time: 22:07
 */

use models\ {
        SmartyClass,
        Pagination,
        SearchModel,
        Session,
        ParamsDisplayImag,
        ExeptionPDOMy,
        ExeptionMy
};

require_once("../../index.php");
require_once("../models/ExeptionMy.php");

$session = new Session();
$message = $session->message();
try {
    $param_pages = ParamsDisplayImag::findAll();
    $result_array = getParamsViewForUsers($param_pages);


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (strlen($_POST['search']) <= 50) {
            $search = $_SESSION['search'] = escapeValue($_POST['search']);
            $se = "%$search%";
        } else {
            throw new ExeptionMy("Поисковый запрос превышает 50 символов");
        }
    } else {
        $search = $_SESSION['search'];
        $se = "$search%";
    }

    if (!isset($_POST['search']) && !isset($_SESSION['search']) && !isset($se)) {
        redirectTo('gallery.php');
    }

    /**
     * Блок задания параметров пагинации
     */
    $page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
    $per_page = $_SESSION['count_images'];
    $photo_obj = new SearchModel();
    $total_count = $photo_obj->getCountForSearch($se);
    $pagination = new Pagination($page, $per_page, $total_count);
    /**
     * Блок получения записей БД для вывода
     */
    $photos = $photo_obj->search($pagination);
} catch  (ExeptionPDOMy $e) {
    $action = " Error on the {$e->getLine()}-lines. Info about";
    $body = "\n{$e->getMessage()}.\nPath: {$e->getFile()}\n\n";
    logAction(LOG_PATH, $action, $body);
    redirectTo('/posts_cap.html');
} catch(ExeptionMy $e) {
    $action = " Error on the {$e->getLine()}-lines. Info about";
    $body = "\n{$e->getMessage()}.\nPath: {$e->getFile()}\n\n";
    logAction(LOG_PATH, $action, $body);
    redirectTo("gallery.php");
}
/**
 * Block template
 */

$smarty = new SmartyClass();
$smarty->assign('photos', $photos);
$smarty->assign('pagination', $pagination);
$smarty->assign('message', $message);
$smarty->display('C:\OpenServer\domains\photogallery\application\smartemplates\search.tpl');
