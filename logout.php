<?php

include('core/config.php');
unset($_SESSION["role"]);
unset($_SESSION["user_name"]);
unset($_SESSION["id"]);
unset($_SESSION["email"]);
unset($_SESSION["store"]);
session_destroy();
redirectTo('login.php');
?>