<?php
    session_start();
    //check if email is set
    if(isset($_POST['userEmail'])) {
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
                    $codeTab = [];
                    for ($i = 0; $i < 5 ;$i++) {
                        $code = random_int(0,9);
                        $codeTab[$i] = $code;
                    }
                    $_SESSION['array'] = $codeTab;
                    $_SESSION['email'] = $_POST['userEmail'];
                    header("Location: /main_files/check_code.php");
                    mysqli_close($conn);
                    break;
                } else {
                    //send error message to email page
                    $_SESSION['error'] = "Nie istnieje konto o podanym adresie email";
                    header("Location: /main_files/email.php");
                }
                mysqli_close($conn);
            }

        } else {
            //send error message to email page
            $_SESSION['error'] = "Wprowadzono niepoprawny adres email";
            header("Location: /main_files/email.php");
        }
    } else header("Location: /main_files/login.php");
?>