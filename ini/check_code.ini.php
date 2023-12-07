<?php 
    session_start();

    if(isset($_SESSION['array'])) {
        $check = true;
        for ($i = 0; $i < 5 ;$i++) {

            if (isset($_POST['input' . ($i + 1)]) && $_POST['input' . $i + 1] != ""){
               if ($_SESSION['array'][$i] == $_POST['input' . $i + 1]) {
                
               } else {
                $_SESSION['error'] = "Zły kod!";
                header("Location: /main_files/check_code.php");
                $check = false;
                break;
               }
            } else {
                $_SESSION['error'] = "Proszę wpisać kod!";
                header("Location: /main_files/check_code.php");
                $check = false;
            }
        }

        if ($check) {
            $db['host'] = "localhost"; // Host name
            $db['user'] = "root"; // Mysql username
            $db['pass'] = ""; // Mysql password
            $db['name'] = "databaseCO"; // Database name
            $conn = mysqli_connect($db['host'], $db['user'], $db['pass'], $db['name']); // Create connection
            $email = $_SESSION['email'];
            unset($_SESSION['email']);
            unset($_SESSION['array']);
    
            // Check connection
            if (!$conn) die("Connection failed: " . mysqli_connect_error());
            //create sql query and execute it
            $sql = "UPDATE users SET stan = 1 WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            if(!$result) {
                die("query failed please try again later");
                $_SESSION['error'] = "Wystąpił błąd podczas odblokowywania konta";
                header("Location: /main_files/check_code.php");
            } else {
                $_SESSION['error'] = "unLock";
                header("Location: /main_files/login.php");
            }
        }

    } else header("Location: /main_files/login.php");
?>