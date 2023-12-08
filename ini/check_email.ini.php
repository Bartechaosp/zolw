<?php
    session_start();
    //check if email is set
    if(isset($_POST['userEmail'])) {
        //Check type of operation
        if (isset($_GET['type']) && isset($_SESSION['iv'])) {
            $type = htmlspecialchars($_GET['type']);
            $iv = $_SESSION['iv'];
            $encrypted_type = openssl_decrypt($type, "AES-128-CTR", "rzeczINoga", 0, $iv);
            
            if ($encrypted_type == "pass") {
              $passChange = true;
            } else header("Location: /main_files/login.php");
          }
        //email validation
        $userEmail = htmlspecialchars($_POST['userEmail']);
        if(str_contains($userEmail, ".")) {
            $db['host'] = "localhost"; // Host name
            $db['user'] = "root"; // Mysql username
            $db['pass'] = ""; // Mysql password
            $db['name'] = "databaseCO"; // Database name
            $conn = mysqli_connect($db['host'], $db['user'], $db['pass'], $db['name']); // Create connection
    
            // Check connection
            if (!$conn) die("Connection failed: " . mysqli_connect_error());
            //create sql query and execute it
            $sql = "SELECT email FROM users;";
            $result = mysqli_query($conn, $sql);
            if(!$result) die("query failed please try again later");
            
            while ($row = mysqli_fetch_row($result)) {
                //fill the code array
                if ($row[0] == $userEmail) {
                    $success = true;
                    break;
                } else $success = false;
            }

            if ($success) {
                $sql = "SELECT stan FROM users WHERE email = '$userEmail'";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_row($result)) $state = $row[0];
                if ($state && isset($passChange)) {
                    $codeTab = [];
                    for ($i = 0; $i < 5 ;$i++) {
                        $code = random_int(0,9);
                        $codeTab[$i] = $code;
                    }
                    $_SESSION['array'] = $codeTab;
                    $_SESSION['email'] = $_POST['userEmail'];
                    header("Location: /main_files/check_code.php?type=$type");
                    
                } else if ($passChange) {
                    $_SESSION['error'] = "Twoje konto zostało zablokowane. By zmienić hasło, należy je odblokować";
                    $_SESSION['lock'] = true;
                    header("Location: /main_files/email.php?type=$type");
                } else {
                    $_SESSION['email'] = $userEmail;
                    header("Location: /main_files/check_code.php");
                }
            
        } else {
            //send error message to email page
            $_SESSION['error'] = "Nie istnieje konto o podanym adresie email";
            if ($passChange) {
                header("Location: /main_files/email.php?type=$type");
            } else {
                header("Location: /main_files/email.php");
            }
        }
        mysqli_close($conn);

        } else {
            //send error message to email page
            $_SESSION['error'] = "Wprowadzono niepoprawny adres email";
            if ($passChange) {
                header("Location: /main_files/email.php?type=$type");
            } else {
                header("Location: /main_files/email.php");
            }
        }
    } else header("Location: /main_files/login.php");
?>