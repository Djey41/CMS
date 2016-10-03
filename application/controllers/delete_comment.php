<?php
use models\ {
       Session,
       Comment,
       ExeptionPDOMy,
       ExeptionMy
};

require_once("../../index.php");

$session = new Session();
if (!$session->isLoggedIn()) { redirectTo("login.php"); }
	try {
  if (empty($_GET['id'])) {
  	throw new ExeptionMy("ID данного комментария не был обнаружен.");
  }

    if (!$comment = Comment::findById($_GET['id'])) {
        throw new ExeptionMy("Данный комментарий невозможно удалить.");
    }
    $comment->delete("id");
    redirectTo("comments.php?id={$comment->photograph_id}");

} catch (ExeptionPDOMy $e) {
    $session->message("Error on the {$e->getLine()}-lines. Info about:\n{$e->getMessage()}.\nPath: {$e->getFile()}\n\n");
    redirectTo("adminindex.php");
} catch (ExeptionMy $e) {
    $session->message($e->getMessage());
    redirectTo("list_photos.php");
}
