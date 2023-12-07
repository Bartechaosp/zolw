<?php
    session_start();

    $db['host'] = "localhost"; // Host name
    $db['user'] = "root"; // Mysql username
    $db['pass'] = ""; // Mysql password
    $db['name'] = "databaseCO"; // Database name
    $rzecz = false;

    // Create connection
    $conn = mysqli_connect($db['host'], $db['user'], $db['pass'], $db['name']);
    
    // Check connection
    if (!$conn) die("Connection failed: " . mysqli_connect_error());

        if(isset($_POST['pass']) && isset($_POST['plmqaz']) && $_POST['pass'] != "") {

            $iv = $_SESSION['iv'];
            unset($_SESSION['iv']);
            $data = $_POST['plmqaz'];
            $decrypted_userName = openssl_decrypt($data, "AES-128-CTR", "rzeczINoga", 0, $iv);

                $userPass = htmlspecialchars($_POST['pass']);

                $sql = "SELECT stan from users where username = '$decrypted_userName'";
                $result = mysqli_query($conn, $sql);

                while($row = mysqli_fetch_row($result)) {
                    if ($row[0] == "0") {
                        $_SESSION['error'] = "Konto zostało zablokowane! Należy je odblokować!";
                        $_SESSION['userName'] = $decrypted_userName;
                        $_SESSION['unLock'] = true;
                        header("Location: /main_files/pass_log.php");
                    } else $rzecz = true;
                }
            if ($rzecz) {
                $sql = "SELECT password_hash from users where username = '$decrypted_userName';";
                $result = mysqli_query($conn, $sql);

                //get data from query
                while ($row = mysqli_fetch_row($result)) {
                    
                    if(password_verify($userPass ,$row[0])) {
                        if(isset($_SESSION['tryLog'])) unset($_SESSION['tryLog']);
                        $_SESSION['loggedIn'] = true;
                        header("Location: /main_files/index.php");
                    } else {
                        if (!isset($_SESSION['tryLog'])) {
                            $_SESSION['tryLog'] = 2;
                            $_SESSION['error'] = "Zostało ci: " . ($_SESSION['tryLog'] + 1) . " prób";
                            $_SESSION['userName'] = $decrypted_userName;
                            header("Location: /main_files/pass_log.php");
                        } else if ($_SESSION['tryLog'] != 0) {
                            $_SESSION['tryLog'] = $_SESSION['tryLog'] - 1;
                            $_SESSION['error'] = "Zostało ci: " . $_SESSION['tryLog'] + 1 . " prób";
                            $_SESSION['userName'] = $decrypted_userName;
                            header("Location: /main_files/pass_log.php");
                        } else {
                            unset($_SESSION['tryLog']);
                            $sql = "UPDATE users set stan = 0 where username = '$decrypted_userName';";
                            $result = mysqli_query($conn, $sql);

                            if ($result) {
                                $_SESSION['unLock'] = true;
                                $_SESSION['error'] = "Konto zostało zablokowane!";
                                $_SESSION['userName'] = $decrypted_userName;
                                header("Location: /main_files/pass_log.php");
                            } else {
                                echo "nie działa";
                            }
                        }
                    }
                }
           }
    } else if (isset($_SESSION['accLock'])) {

        $iv = $_SESSION['iv'];
        unset($_SESSION['iv']);
        $data = $_POST['plmqaz'];
        $decrypted_userName = openssl_decrypt($data, "AES-128-CTR", "rzeczINoga", 0, $iv);

        $sql = "UPDATE users set stan = 0 where username = '$decrypted_userName';";
        $result = mysqli_query($conn, $sql);

        unset($_SESSION['accLock']);

        $sql = "UPDATE users SET stan = 0 WHERE username = '$decrypted_userName'";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $_SESSION['error'] = "Konto zostało zabloowane! Należy je odblokować!";
            $_SESSION['userName'] = $decrypted_userName;
            header("Location: /main_files/pass_log.php");
        } else {
            echo "nie działa";
        }
    } else {
        $iv = $_SESSION['iv'];
        unset($_SESSION['iv']);
        $data = $_POST['plmqaz'];
        $decrypted_userName = openssl_decrypt($data, "AES-128-CTR", "rzeczINoga", 0, $iv);
        
        $_SESSION['error'] = "Pole hasło jest puste!";
        $_SESSION['userName'] = $decrypted_userName;
        header("Location: /main_files/pass_log.php");
    }
    
    // Close MySQL connection
    mysqli_close($conn);
?>