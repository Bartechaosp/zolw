<?php
    session_start();
    if(!isset($_SESSION['loggedIn'])) {
        header("Location: main_files/login.php");
    }

    if(isset($_SESSION['loggedIn'])) {
        unset($_SESSION['loggedIn']);
        unset($_SESSION['userName']);
        header("Location: main_files/login.php");
    }
?>