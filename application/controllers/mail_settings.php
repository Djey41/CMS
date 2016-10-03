<?php
/**
 * Created by PhpStorm.
 * User: sapphirehead
 * Date: 12.05.2016
 * Time: 22:34
 */
use models\ {
       SmartyClass,
       PHPMailerClass,
       Session,
       ExeptionPDOMy,
       ExeptionMy
};

require_once("../../index.php");

$session = new Session();
if (!$session->isLoggedIn()) { redirectTo("login.php"); }
$message = $session->message();

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $host = escapeValue($_POST['host']);
        $mail_from = validateValueForEmail($_POST['mail_from']);
        $pass = escapeValue($_POST['password']);
        $port = escapeIntValue($_POST['port']);
        $overall_name = escapeValue($_POST['overall_name']);
        $mail_for = validateValueForEmail($_POST['mail_for']);
        $recipient = escapeValue($_POST['recipient']);
        $header = escapeValue($_POST['header']);
        // пишем хеш в БД
        $reg_obj = new PHPMailerClass();
        $password = encrypt($pass);
        $propertys_obj = $reg_obj->makeMailObj($host, $mail_from, $password, $port, $overall_name, $mail_for, $recipient,
            $header);

            $propertys_obj->saveDB();
            redirectTo("adminindex.php");
    } else {
        $propertys_obj = new PHPMailerClass();
        $propertys_obj->host = "";// yandex.ru
        $propertys_obj->mail_from = "";// Site
        $propertys_obj->password = "";
        $propertys_obj->port = "";// 587
        $propertys_obj->overall_name = "";// subject (theme)
        $propertys_obj->mail_for = "";// адрес кому
        $propertys_obj->recipient = "";// от кого
        $propertys_obj->header = "";// главный заголовок (титул)
    }
} catch (ExeptionPDOMy $e) {
    $session->message("Error on the {$e->getLine()}-lines. Info about:\n{$e->getMessage()}.\nPath: {$e->getFile()}\n\n");
    redirectTo("adminindex.php");
} catch (ExeptionMy $e) {
    $session->message($e->getMessage());
    redirectTo("mail_settings.php");
}
/**
 * Block template
 */

$smarty = new SmartyClass();
$smarty->assign('mail', $propertys_obj);
$smarty->assign('message', $message);
$smarty->display('C:\OpenServer\domains\photogallery\application\smartemplates\mail_settings.tpl');
