<?php
    session_start();

    //Check if access is allowed
    if (isset($_GET['type']) && isset($_SESSION['iv']) && isset($_POST['pass']) && isset($_POST['passv2']) && isset($_SESSION['email'])) {
        $pass = $_POST['pass'];
        $pass2 = $_POST['passv2'];
        $type = htmlspecialchars($_GET['type']);
        $email = $_SESSION['email'];
        $iv = $_SESSION['iv'];
        $encrypted_type = openssl_decrypt($type, "AES-128-CTR", "rzeczINoga", 0, $iv);
        
        if ($encrypted_type == "pass") {
          $passChange = true;
        } else header("Location: /main_files/login.php");
      } else header("Location: /main_files/login.php");

      if ($passChange) {
        echo $pass;
        $regex = "/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*]).{8,}$/";
        if (!empty($pass) && !empty($pass2)) {
            echo $pass . "1";
            if (preg_match($regex, $pass))
             {
                echo $pass . "2";
                if ($pass == $pass2) {
                    $newPass = password_hash($pass, PASSWORD_BCRYPT);

                    $db['host'] = "localhost"; // Host name
                    $db['user'] = "root"; // Mysql username
                    $db['pass'] = ""; // Mysql password
                    $db['name'] = "databaseCO"; // Database name

                    // Create connection
                    $conn = mysqli_connect($db['host'], $db['user'], $db['pass'], $db['name']);
                    
                    // Check connection
                    if (!$conn) die("Connection failed: " . mysqli_connect_error());
                    
                        $sql = "UPDATE users SET password_hash = '$newPass' WHERE email = '$email'";
                        $result = mysqli_query($conn, $sql);
                        if ($result) {
                            $_SESSION['error'] = ["success", "Hasło zmienione poprawnie"];
                            unset($_SESSION['email']);
                            mysqli_close($conn);
                            header("Location: /main_files/login.php?");
                        } else {
                            $_SESSION['error'] = ["error", "Wystąpił problem podczas aktualizacji hasła, jeśli problem będzie się powtarzać, skontaktuj się z nami"];
                            unset($_SESSION['email']);
                            mysqli_close($conn);
                            header("Location: /main_files/login.php");
                        }
                } else {
                    $_SESSION['error'] = "Hasła się różnią";
                    header("Location: /main_files/newPass.php?type=$type");
                }
            } else {
                echo "eeee";
                $_SESSION['error'] = "Hasło musi zawierać przynajmniej dużą i małą literę i składać się co najmniej z 8 znaków";
                header("Location: /main_files/newPass.php?type=$type");
            }
        } else {
            $_SESSION['error'] = "Proszę wypełnić wszystkie pola";
            header("Location: /main_files/newPass.php?type=$type");
        }
      } echo "elo";
?>