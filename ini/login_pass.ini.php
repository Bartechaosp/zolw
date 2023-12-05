<?php
    session_start();

    $db['host'] = "localhost"; // Host name
    $db['user'] = "root"; // Mysql username
    $db['pass'] = ""; // Mysql password
    $db['name'] = "databaseCO"; // Database name
    
        if(isset($_POST['pass']) && isset($_POST['plmqaz'])) {
            if(!empty($_POST['pass'])) {
                $iv = $_SESSION['iv'];
                $data = $_POST['plmqaz'];
                echo $iv;
                $decrypted_userName = openssl_decrypt($data, "AES-128-CTR", "rzeczINoga", 0, $iv);
                echo $decrypted_userName;
                $userPass = htmlspecialchars($_POST['pass']);

                // Create connection
                $conn = mysqli_connect($db['host'], $db['user'], $db['pass'], $db['name']);
    
                // Check connection
                if (!$conn) die("Connection failed: " . mysqli_connect_error());
            
                $sql = "SELECT password_hash from users where username = '$decrypted_userName';";
                $result = mysqli_query($conn, $sql);

                //get data from query
                while ($row = mysqli_fetch_row($result)) {
                    if($row[0] == $decrypted_userName) {
                        $_SESSION['loggedIn'] = true;
                        header("Location: /main_files/index.php");
                    } else {
                        $_SESSION['error'] = "Wprowadzono niepoprawne hasło";
                        $_SESSION['userName'] = $decrypted_userName;
                        header("Location: /main_files/pass_log.php");
                    }
                }
            }

    } else header("Location: main_files/login.php");
    
    // Close MySQL connection
    mysqli_close($conn);
?>