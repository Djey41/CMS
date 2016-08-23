<?php
use Models\ {
       Session,
       Comment,
       ModelsPDOException,
       ModelsException
};

require_once ("../../initialize.php");

$session = new Session();
if (!$session->isLoggedIn()) { redirectTo("login.php"); }
	try {
  if (empty($_GET['id'])) {
  	throw new ModelsException("ID данного комментария не был обнаружен.");
  }

    if (!$comment = Comment::findById($_GET['id'])) {
        throw new ModelsException("Данный комментарий невозможно удалить.");
    }
    $comment->delete("id");
    redirectTo("comments.php?id={$comment->photograph_id}");

} catch (ModelsPDOException $e) {
    $session->message($e->getMessage());
    redirectTo("adminindex.php");
} catch (ModelsException $e) {
    $session->message($e->getMessage());
    redirectTo("adminindex.php");
}