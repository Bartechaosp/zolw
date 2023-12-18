<?php
    session_start();
    $db['host'] = "localhost"; // Host name
    $db['user'] = "root"; // Mysql username
    $db['pass'] = ""; // Mysql password
    $db['name'] = "databaseCO"; // Database name


        if(isset($_POST['login'])){
                // Create connection
                $conn = mysqli_connect($db['host'], $db['user'], $db['pass'], $db['name']);
        
                // Check connection
                if (!$conn) die("Connection failed: " . mysqli_connect_error());

                $userLogin = htmlspecialchars($_POST['login']);
                $userPass = htmlspecialchars($_POST['haslo']);
                $userEmail = htmlspecialchars($_POST['email']);
                $hashPass = password_hash($userPass, PASSWORD_BCRYPT);

            $sql = "SELECT COUNT(username) from users where username = '$userLogin';";
                $result = mysqli_query($conn, $sql);
            
            while ($row = mysqli_fetch_row($result)) {
                if($row[0] == 1) {
                    $_SESSION['error'] = ["error" ,"Konto o podanym loginie już istnieje"];
                    header("Location: /main_files/login.php");
                } else {
                
                    $sql1 = "INSERT INTO users (username, password_hash, email, role, stan)
                    VALUES ('$userLogin', '$hashPass', '$userEmail', 0, 1)";
                    if (mysqli_query($conn, $sql1)) {
                        echo "Dodano";
                        $_SESSION['error'] = ["success", "Rejestracja przebiegła pomyślnie"];
                        header("Location: /main_files/login.php");
                    }
                    else{
                        $_SESSION['error'] = "BŁĄD";
                        header("Location: /main_files/login.php");
                    }
                }
            }
        }
?>