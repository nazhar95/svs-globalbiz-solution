<?php
    include("../inc/dbconfig.php");

    //start session
    session_start();
    
    //check user authorization
    if(empty($_SESSION["login_user"]) || ($_SESSION["user_role"]!=2)) 
    { 
        echo
        '
        <script>
        window.alert("Error: Unauthorized access.");
        window.location= "../login.php";
        </script>
        ';
    }
?>
