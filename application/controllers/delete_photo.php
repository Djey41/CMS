<?php
use models\ {
       Session,
       Photograph,
       ExeptionMy,
       ExeptionPDOMy
};

require_once("../../index.php");

$session = new Session();
if (!$session->isLoggedIn()) { redirectTo("login.php"); }
try {
    if (empty($_GET['id'])) {
        throw new ExeptionMy("ID данного изображения не передан.");
    }
    if (!$photo = Photograph::findById($_GET['id'])) {
        throw new ExeptionMy("Такого изображения не существует.");
    }
    $photo->destroy();
    redirectTo("list_photos.php");

} catch (ExeptionPDOMy $e) {
    $session->message("Error on the {$e->getLine()}-lines. Info about:\n{$e->getMessage()}.\nPath: {$e->getFile()}\n\n");
    redirectTo("adminindex.php");
} catch (ExeptionMy $e) {
    $session->message($e->getMessage());
    redirectTo("list_photos.php");
}
