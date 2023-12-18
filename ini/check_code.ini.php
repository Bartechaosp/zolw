<?php 
    session_start();

    if(isset($_SESSION['array'])) {
        $check = true;
        $passChange = false;
        $array = $_SESSION['array'];
        //unset($_SESSION['array']);
        //Check type of operation
        if (isset($_GET['type']) && isset($_SESSION['iv'])) {
            $type = htmlspecialchars($_GET['type']);
            $iv = $_SESSION['iv'];
            //unset($_SESSION['iv']);
            $encrypted_type = openssl_decrypt($type, "AES-128-CTR", "rzeczINoga", 0, $iv);
            
            if ($encrypted_type == "pass") {
                echo $encrypted_type;
              $passChange = true;
            } else header("Location: /main_files/login.php");
          }
        //check if the code is correct
        for ($i = 0; $i < 5 ;$i++) {

            if (isset($_POST['input' . ($i + 1)]) && $_POST['input' . $i + 1] != ""){
               if ($array[$i] == $_POST['input' . $i + 1]) {
                
               } else {
                $check = false;
                $_SESSION['error'] = "Zły kod!";
                if ($passChange) {
                    header("Location: /main_files/check_code.php?type=$type");
                    $passChange = false;
                    break;
                } else header("Location: /main_files/check_code.php");
                break;
               }
            } else {
                $check = false;
                $_SESSION['error'] = "Proszę wpisać kod!";
                if ($passChange) {
                    header("Location: /main_files/check_code.php?type=$type");
                    exit();
                    //$passChange = false;
                    //$passChange = false;
                } else  header("Location: /main_files/check_code.php");
                break;
            }
        }

        if ($check == true && $passChange == false) {
            $db['host'] = "localhost"; // Host name
            $db['user'] = "root"; // Mysql username
            $db['pass'] = ""; // Mysql password
            $db['name'] = "databaseCO"; // Database name
            $conn = mysqli_connect($db['host'], $db['user'], $db['pass'], $db['name']); // Create connection
            $email = $_SESSION['email'];
    
            // Check connection
            if (!$conn) die("Connection failed: " . mysqli_connect_error());
            //create sql query and execute it
            $sql = "UPDATE users SET stan = 1 WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            if(!$result) {
                die("query failed please try again later");
                $_SESSION['error'] = ["error" ,"Wystąpił błąd podczas odblokowywania konta"];
                header("Location: /main_files/check_code.php");
            } else {
                $_SESSION['error'] = ["success", "Twoje konto zostało odblokowane poprawnie. Możesz się zalogować lub zmienić hasło"];
                header("Location: /main_files/login.php");
            }
        } else if ($check == true && $passChange) header("Location: /main_files/newPass.php?type=$type");

    } else header("Location: /main_files/login.php");
?>