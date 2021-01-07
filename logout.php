<?php
    session_start();
    unset($_SESSION["login_user"]);
    unset($_SESSION["user_role"]);
    unset($_SESSION["loggedin"]);
    header("location:index.php");
?>