<?php
use models\ {
        Photograph,
        Pagination,
        SmartyClass,
        ParamsDisplayImag,
        ExeptionPDOMy,
        Session,
        ErrorMy
};

require_once("../../index.php");
require_once("../models/ExeptionMy.php");

$session = new Session();
try {
    $param_pages = ParamsDisplayImag::findAll();
    $result_array = getParamsViewForUsers($param_pages);

    /**
     * Блок задания параметров пагинации
     */
    $page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
    $total_count = Photograph::countAll();
    $pagination = new Pagination($page, $result_array->count_images, $total_count);

    /**
     * Блок выборки для вывода из БД
     */
    if (!empty($result_array->sort)) {
        if ($result_array->sort == 'views') {
            $sql = "SELECT id, filename, prew_name, type, size, caption, alt, views, dt FROM photographs ";
            $sql .= "ORDER BY views DESC ";
            $sql .= "LIMIT {$result_array->count_images} ";
            $sql .= "OFFSET {$pagination->offset()}";
        } elseif ($result_array->sort == 'comments') {
            $sql = "SELECT photographs.id, filename, prew_name, type, size, caption, alt, views, dt,
comments.photograph_id FROM photographs ";
            $sql .= "INNER JOIN  comments ON photographs.id = comments.photograph_id ";
            $sql .= "GROUP BY photographs.id DESC ";
            $sql .= "LIMIT {$result_array->count_images} ";
            $sql .= "OFFSET {$pagination->offset()}";
        }
    }

    $photos = Photograph::findBySql($sql);

} catch  (ExeptionPDOMy $e) {
    $action = " Error on the {$e->getLine()}-lines. Info about";
    $body = "\n{$e->getMessage()}.\nPath: {$e->getFile()}\n\n";
    logAction(LOG_PATH, $action, $body);
    redirectTo('posts_cap.html');
} catch(ErrorMy $e) {
    $action = " Error on the {$e->getLine()}-lines. Info about";
    $body = "\n{$e->getMessage()}.\nPath: {$e->getFile()}\n\n";
    logAction(LOG_PATH, $action, $body);
    tryToSendMessageToPost($action, $body, null);
    redirectTo('posts_cap.html');
}
/**
 * Block template
*/

$smarty = new SmartyClass();
$smarty->assign('photos', $photos);
$smarty->assign('pagination', $pagination);
$smarty->display('C:\OpenServer\domains\photogallery\smartemplates\gallery.tpl');
