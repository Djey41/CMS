<?php
use models\Session;
use models\SmartyClass;
use models\ExeptionMy;

require_once("../../index.php");

$logfile = __DIR__ . '/../../logs/' . escapeValue($_GET['path_log']);
$session = new Session();
$message = $session->message();
if (!$session->isLoggedIn()) {
    redirectTo("login.php");
}
try {
    if ($_GET['clear'] == 'true') {
        if (!empty($_GET['path_log'])) {
            file_put_contents($logfile, '');
            logAction($logfile, 'Logs Cleared', "by User ID {$session->user_id}");
            redirectTo('logfile.php?path_log='. $_GET['path_log']);
        } else {
            throw new ExeptionMy("Не передан путь к лог-файлу.");
        }
    }
} catch (ExeptionMy $e) {
    $session->message($e->getMessage());
    redirectTo('adminindex.php');
}

/**
 * Block template
 */

$smarty = new SmartyClass();
$smarty->assign('logfile', $logfile);
$smarty->assign('message', $message);
$smarty->display('C:\OpenServer\domains\photogallery\closed\smartemplates\logfile.tpl');
