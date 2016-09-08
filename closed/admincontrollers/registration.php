<?php
/**
 * Created by PhpStorm.
 * User: sapphirehead
 * Date: 05.05.2016
 * Time: 23:49
 */

use models\ {
       SmartyClass,
       User,
       Session,
       ExeptionPDOMy,
       ExeptionMy
};

require_once("../../index.php");

$session = new Session();
$message = $session->message();
try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = sanitizeValueStrong($_POST['username']);
        if ($_POST['password'] == $_POST['password2']) {
            $password = escapeValue($_POST['password']);
            $first_name = escapeValue($_POST['first_name']);
            $last_name = escapeValue($_POST['last_name']);
            if (!preg_match('/^[a-zA-Z][a-zA-Z0-9-_\.]{1,20}$/', $username)) {
                throw new ExeptionMy("Для логина возоможен выбор только из  латиницы (регистронезависимо) и цифр 
                (всего 2-20 символов)");
            }
        if (!preg_match('/(?=^.{8,}$)(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s)[0-9a-zA-Z!?@#$%^&*()]*$/',  $password)) {
                throw new ExeptionMy("Для пароля неоходима латиница обязателен верхний и нижний регистр и цифры 
                и какой-нибудь из этих символов: !?@#$%^&  (всего минимум 8 символов)");
        }
        $reg_obj = new User();
         $propertys_obj = $reg_obj->getUserPropertys($username, $password, $first_name, $last_name, $part_sql);
         $part_sql = 'OR';
                if (!$found_user = $reg_obj->getAuthenticFromBD($username, $password, $part_sql)) {
                    $propertys_obj->saveDB();
                    redirectTo("adminindex.php");
                } else {
                    throw new ExeptionMy("Такой логин или пароль уже существует!");
                }
        } else {
            throw new ExeptionMy("Пароли не совпадают");
        }
    } else {
        $propertys_obj = new User();
        $username = "";
        $propertys_obj->username = "";
        $propertys_obj->password = "";
        $propertys_obj->first_name = "";
        $propertys_obj->last_name = "";
    }
} catch (ExeptionPDOMy $e) {
    $session->message($e->getMessage());
    redirectTo("adminindex.php");
} catch (ExeptionMy $e) {
    $session->message($e->getMessage());
    redirectTo("registration.php");
}
/**
 * Block template
 */

$smarty = new SmartyClass();
$smarty->assign('reg', $propertys_obj);
$smarty->assign('username', $username);
$smarty->assign('message', $message);
$smarty->display('C:\OpenServer\domains\photogallery\public\Smartemplates\mytemplates\registration.tpl');
