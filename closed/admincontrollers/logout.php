<?php
use models\Session;

require_once("../../index.php");
    $session = new Session();
    $session->logout();
    redirectTo("login.php");
