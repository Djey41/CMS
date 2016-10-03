<?php
/**
 * Created by PhpStorm.
 * User: sapphirehead
 * Date: 08.05.2016
 * Time: 19:22
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
if (!$session->isLoggedIn()) { redirectTo("login.php"); }
$message = $session->message();
try {
        if ($_SERVER['REQUEST_METHOD']=='POST') {
            $username = escapeValue($_POST['username']);
            if (!preg_match('/^[a-zA-Z][a-zA-Z0-9-_\.]{1,20}$/', $username)) {
                throw new ExeptionMy("Для логина возоможен выбор только из  латиницы (регистронезависимо) и цифр (всего 2-20 символов)");
            }
            $salt = "24akjJ0340LJafkri3409jag";
            $options = [
                'cost' => 12,
                'salt' => $salt
            ];
            if ($_POST['new_password'] === $_POST['new_password2']) {

                $old_password = escapeValue($_POST['old_password']);
                $new_password = escapeValue($_POST['new_password']);
                if (!preg_match('/(?=^.{8,}$)(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s)[0-9a-zA-Z!?@#$%^&*()]*$/',  $new_password)) {
                    throw new ExeptionMy("Для пароля неоходима латиница обязателен верхний и нижний регистр и цифры и какой-нибудь из этих символов: !?@#$%^&  (всего минимум 8 символов)");
                }
                $first_name = escapeValue($_POST['first_name']);
                $last_name = escapeValue($_POST['last_name']);
                $chang_obj = new User();
                // сравниваем введённого юзера и сессионного, чтоб не вводили имя другого юзера-админа
                $propertys_obj = $chang_obj->getUserPropertys($username, $new_password, $first_name, $last_name);
                $part_sql = 'OR';
                if ($found_user = $chang_obj->getAuthenticFromBD($username, $old_password, $part_sql)) {
                        if ($found_user->password === myHash($old_password)) {
                            $propertys_obj->saveDB();
                            redirectTo("adminindex.php");
                        } else {
                            throw new ExeptionMy("Такой логин уже есть и пароль для него не совпадает!");
                        }
                    } else {
                        throw new ExeptionMy("Аутентификация не пройдена!");
                    }
            } else{
                throw new ExeptionMy("Пароли не совпадают!");
            }
        } else {
            $found_user = new User();
            $username = "";$found_user->username = "";
            $found_user->password = "";
            $found_user->first_name = "";
            $found_user->last_name = "";
        }
} catch (ExeptionPDOMy $e) {
    $session->message("Error on the {$e->getLine()}-lines. Info about:\n{$e->getMessage()}.\nPath: {$e->getFile()}\n\n");
    redirectTo("adminindex.php");
} catch (ExeptionMy $e) {
    $session->message($e->getMessage());
    redirectTo("chang_pass.php");
}
/**
 * Block template
 */

$smarty = new SmartyClass();
$smarty->assign('chang', $found_user);
$smarty->assign('username', $username);
$smarty->assign('message', $message);
$smarty->display('C:\OpenServer\domains\photogallery\application\smartemplates\chang_pass.tpl');
