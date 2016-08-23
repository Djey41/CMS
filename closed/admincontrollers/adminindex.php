<?php
use Models\ {
       Session,
       SmartyClass
};

require_once ('../../initialize.php');

$session = new Session();
$message = $session->message();
if (!$session->isLoggedIn()) { redirectTo("login.php"); }

/**
 * Block template
 */

$smarty = new SmartyClass();
$smarty->assign('message', $message);
$smarty->display('C:\OpenServer\domains\photogallery\public\Smartemplates\mytemplates\adminindex.tpl');

//if (isset(CoreDatabase::$db)) { CoreDatabase::$db->closeConnection(); }
