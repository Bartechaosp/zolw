<?php
    session_start();

    $db['host'] = "localhost"; // Host name
    $db['user'] = "root"; // Mysql username
    $db['pass'] = ""; // Mysql password
    $db['name'] = "databaseCO"; // Database name
    
        if(isset($_POST['login'])) {
            if(!empty($_POST['login'])) {
                $userLogin = htmlspecialchars($_POST['login']);

                // Create connection
                $conn = mysqli_connect($db['host'], $db['user'], $db['pass'], $db['name']);
    
                // Check connection
                if (!$conn) die("Connection failed: " . mysqli_connect_error());
            
                $sql = "SELECT COUNT(username) from users where username = '$userLogin';";
                $result = mysqli_query($conn, $sql);

                //get data from query
                while ($row = mysqli_fetch_row($result)) {
                    if($row[0] == 1) {
                        $_SESSION['userName'] = $userLogin;
                        header("Location: /main_files/pass_log.php");
                    } else {
                        $_SESSION['error'] = ["error" ,"Konto o podanym loginie nie istnieje"];
                        header("Location: /main_files/login.php");
                    }
                }
            }

    } else header("Location: main_files/login.php");
    
    // Close MySQL connection
    mysqli_close($conn);
?>