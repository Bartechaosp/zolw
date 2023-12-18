<?php 
    session_start();
    if (isset($_GET['url']) && isset($_SESSION['uId'])) {

        $url = $_POST['url'];
        $uId = $_SESSION['uId'];
        $db['host'] = "localhost"; // Host name
            $db['user'] = "root"; // Mysql username
            $db['pass'] = ""; // Mysql password
            $db['name'] = "databaseCO"; // Database name
            $conn = mysqli_connect($db['host'], $db['user'], $db['pass'], $db['name']); // Create connection
    
            //Check connection
            if (!$conn) die("Connection failed: " . mysqli_connect_error());

            $sql = "SELECT count(session_id), expiration_time FROM sessions WHERE user_id = '$uId'";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_row($result)) {
                $time = time();
                if($row[0] == 1 && $time < $row[1]){
                    if ($exp - $time < 600) {
                        $time += 600;
                        $sql = "UPDATE sessions SET expiration_time = $time WHERE user_id = '$uId'";
                        $result = mysqli_query($conn, $sql);
                        mysqli_close($conn);
                    }
                } else {
                    $sql = "DELETE FROM sessions WHERE user_id = '$uId'";
                    $result = mysqli_query($conn, $sql);
                    mysqli_close($conn);
                    $_SESSION['error'] = ["error" ,"Twoja sesja wygasła, więc nastąpiło wylogowanie. Proszę zalogować się ponownie"];
                    header("Location: /main_files/login.php");
                }
            }
    } else header("Location: /main_files/login.php");
?>