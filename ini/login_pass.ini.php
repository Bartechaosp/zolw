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

        if(isset($_POST['pass']) && isset($_POST['plmqaz']) && !empty($_POST['pass'])) {

            $iv = $_SESSION['iv'];
            //unset($_SESSION['iv']);
            $data = $_POST['plmqaz'];
            $decrypted_userName = openssl_decrypt($data, "AES-128-CTR", "rzeczINoga", 0, $iv);
            $seesion_tocken = openssl_decrypt($data, "AES-128-CTR", "rzeczINoga", 0, 12345);

                $userPass = htmlspecialchars($_POST['pass']);

                $sql = "SELECT stan from users where username = '$decrypted_userName'";
                $result = mysqli_query($conn, $sql);
                //check if account is locked. If yes = return an error, else set $rzecz to true and execute code
                while($row = mysqli_fetch_row($result)) {
                    if (empty($row[0])) {
                        $_SESSION['error'] = "Konto zostało zablokowane! Należy je odblokować!";
                        $_SESSION['userName'] = $decrypted_userName;
                        $_SESSION['unLock'] = true;
                        header("Location: /main_files/pass_log.php");
                    } else{
                        $rzecz = true;
                    } 
                }
            if ($rzecz) {
                //get user id and  from query
                $sql = "SELECT password_hash, user_id, role from users where username = '$decrypted_userName';";
                $result = mysqli_query($conn, $sql);

                while ($row = mysqli_fetch_row($result)) {
                    
                    if(password_verify($userPass ,$row[0])) {
                        $uId = $row[1];
                        $role = $row[2];
                        $passCorrect = true;
                        break;
                    } else {
                        $passCorrect = false;
                    }
                }

                if ($passCorrect) {
                    $_SESSION['userName'] = $decrypted_userName;
                    //reset unsuccess try to login
                    if(isset($_SESSION['tryLog'])) unset($_SESSION['tryLog']);
                    $sql = "SELECT count(session_id) FROM sessions WHERE user_id = $uId";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_row($result)) {
                        if ($row[0] == 1) {
                            $login = true;
                            break;
                        } else $login = false;
                    }
                    if ($login) {
                        //$_SESSION['ok'] = true;
                        $_SESSION['uId'] = $uId;
                        header("Location: /main_files/index.php");
                    }
                    if (!$login) {
                        //session tocken prepare
                        $max_time = time() + 900;
                        //prepare create session sql query and execute it
                        $sql = "INSERT INTO sessions VALUES(null, $uId, '$decrypted_userName', $max_time)";
                        $result = mysqli_query($conn, $sql);
                            $_SESSION['uId'] = $uId;
                            $_SESSION['role'] = $role;
                            //$_SESSION['ok'];
                            header("Location: /main_files/index.php");
                    }
                }

                if (!$passCorrect) {
                    echo "elo2";
                    if (isset($_SESSION['tryLog']) && $_SESSION['tryLog'] == 0) $_SESSION['tryLog'] = "lock"; 

                    switch ($_SESSION['tryLog']) {
                        //if tryLog is set and is equal 0, lock an account, unset tryLog session
                        //and display an information about locked account
                        case "lock":
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
                            break;
                        //if tryLog is not equal 0 and is set it means that user typed wrong pass.
                        //Decrement tryLog and display an information about how match try is still avalieble
                        case !0:
                            $_SESSION['tryLog'] = $_SESSION['tryLog'] - 1;
                            $_SESSION['error'] = "Zostało ci: " . $_SESSION['tryLog'] + 1 . " prób";
                            $_SESSION['userName'] = $decrypted_userName;
                            header("Location: /main_files/pass_log.php");
                            break;
                        //if tryLog is not set, set it to 2
                        case null:
                            $_SESSION['tryLog'] = 2;
                            $_SESSION['error'] = "Zostało ci: " . ($_SESSION['tryLog'] + 1) . " prób";
                            $_SESSION['userName'] = $decrypted_userName;
                            header("Location: /main_files/pass_log.php");
                            break;
                    }
                }
           } else "echo 3";
   
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