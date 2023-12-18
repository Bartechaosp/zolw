<?php
    session_start();
    if(!isset($_SESSION['uID'])) {
        header("Location: /main_files/login.php");
    }

    if(isset($_SESSION['uId'])) {
        $db['host'] = "localhost"; // Host name
        $db['user'] = "root"; // Mysql username
        $db['pass'] = ""; // Mysql password
        $db['name'] = "databaseCO"; // Database name
        $uId = $_SESSION['uId'];
    
        // Create connection
        $conn = mysqli_connect($db['host'], $db['user'], $db['pass'], $db['name']);
        
        // Check connection
        if (!$conn) die("Connection failed: " . mysqli_connect_error());

        $sql = "DELETE FROM sessions WHERE user_id = $uId";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $_SESSION['error'] = ["success", "Poprawnine wylogowano"];
            header("Location: /main_files/login.php");
        } else {
            $_SESSION['error'] = ["error", "Wystąpił błąd podczas wylogowanaia, jak najszybciej skontaktuj się z administratorem"];
            header("Location: /main_files/login.php");
        }
    }
?>