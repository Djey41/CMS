<?php
use Models\Session;

require_once ("../../initialize.php");
    $session = new Session();
    $session->logout();
    redirectTo("login.php");