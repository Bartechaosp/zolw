<?php
    session_start();
    if (isset($_SESSION['role'])) {
        $role = $_SESSION['role'];
    }
    $nazwa = $_SESSION['userName'];
    $elo = "rzecz";

    $db['host'] = "localhost"; // Host name
    $db['user'] = "root"; // Mysql username
    $db['pass'] = ""; // Mysql password
    $db['name'] = "databaseCO"; // Database name
    $alert = "";
    $time = time();
    // Create connection
    $conn = mysqli_connect($db['host'], $db['user'], $db['pass'], $db['name']);
    
    // Check connection
    if (!$conn) die("Connection failed: " . mysqli_connect_error());

    if (isset($_SESSION['uId']) && isset($_SESSION['userName'])) {
        $uId = $_SESSION['uId'];
        $userName = $_SESSION['userName'];
    } else {
        header("Location: /main_files/login.php");
        
    }
    $sql = "SELECT count(session_id), expiration_time FROM sessions WHERE user_id = $uId";
    $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_row($result)) {
            if ($row[0] == 1 && $time < $row[1]) {
                $ok = true;
            } else $ok = false;
        }

        if ($ok && $exp - $time < 600) {
                $time += 600;
                $sql = "UPDATE sessions SET expiration_time = $time WHERE user_id = $uId";
                $result = mysqli_query($conn, $sql);
            }

        if (!$ok) {
                $sql = "DELETE FROM sessions WHERE user_id = $uId";
                $result = mysqli_query($conn, $sql);
                mysqli_close($conn);
                $_SESSION['error'] = ["error" ,"Twoja sesja wygasła, więc nastąpiło wylogowanie. Proszę zalogować się ponownie"];
                header("Location: /main_files/login.php");
            }

    
    function logi($kto, $co, $conn){
        $sqlsiemano = "SELECT user_id from users WHERE username = '$kto';";
        $elosiemandero = mysqli_query($conn, $sqlsiemano);
        while ($row = mysqli_fetch_row($elosiemandero)) {
            $idgoscia = $row[0];
        }
        $sqlnara = "INSERT INTO logs VALUES (null, $idgoscia, '$co', NOW());";
        mysqli_query($conn, $sqlnara);
        
    }

    if(isset($_POST['usunkat'])){
        if ($role == 1) {
        $katdousun = $_POST['katdousun'];
        $sql5 = "DELETE  FROM content_categories WHERE category_id = $katdousun ";
        if($katdousun == "dwas"){
             echo "<script>alert('Wybierz kategorie')</script>";
        }else{
        if (mysqli_query($conn, $sql5)) {
            logi($nazwa, "USUNĄŁ KATEGORIE",$conn);
            //$alert = "<script>alert('Kategoria usunięta')</script>";
            echo "<script>alert('Kategoria usunięta')</script>";
        }
    }
        } else  echo "<script>alert('ni ma')</script>";
    }   
    if(isset($_POST['zmienkate'])){
        if ($role == 1) {
    $nowanazwa = $_POST['zmienkat'];
    $staranazwa = $_POST['idkategori'];
    if($staranazwa == "wsad"){
        echo "<script>alert('Wybierz kategorie do zmiany')</script>"; 
    }else{
        $sql12 = "UPDATE content_categories SET category_name = '$nowanazwa' WHERE category_id = $staranazwa;";
        if (mysqli_query($conn, $sql12)) {
            logi($nazwa, "ZMIANA KATEGORII",$conn);
            echo "<script>alert('Nazwa kategorii zmieniona')</script>";
        } 
    }
} else echo "<script>alert('ni ma')</script>";
   }
   
    if(isset($_POST['zmienrange'])){
        if ($role == 1) {
    $polelogin = $_POST['polelogin'];
    $poleemail = $_POST['poleemail'];
    $poleranga = $_POST['jakapermisja'];
        
        if(!empty($polelogin) && empty($poleemail)){
            $sql5 = "UPDATE users SET role = $poleranga WHERE username = '$polelogin';";
            if (mysqli_query($conn, $sql5)) {
                logi($nazwa, "ZMIANA RANGI",$conn);
                echo "<script>alert('Ranga zmieniona')</script>";
            } 
        }
        if(empty($polelogin) && !empty($poleemail)){
            $sql5 = "UPDATE users SET role = $poleranga WHERE email = '$poleemail';";
            if (mysqli_query($conn, $sql5)) {
                logi($nazwa, "ZMIANA RANGI",$conn);
                echo "<script>alert('Ranga zmieniona')</script>";
            } 
        }
        if(!empty($polelogin) && !empty($poleemail)){
            echo "<script>alert('Podaj albo login albo email')</script>";
        }
    } else echo "<script>alert('ni ma')</script>";
    }
    
    
    if(isset($_POST['usunpost'])){
        $nazwatyt = $_POST['titleusunpost'];
        $sql5 = "DELETE  FROM content_items WHERE item_id= $nazwatyt ";
        if($nazwatyt == "wsad"){
            echo "<script>alert('Wybierz post do usunięcia')</script>"; 
        }else{
        if (mysqli_query($conn, $sql5)) {
            logi($nazwa, "USUNIĘCIE POSTU",$conn);
            echo "<script>alert('Post usunięty')</script>";
        }
    }
}

    if(isset($_POST['dodajkate'])){
        if ($role == 1) {
        $nazwakate = $_POST['dodajkat'];
        $sql2 = "INSERT INTO content_categories (category_name)
                    VALUES ('$nazwakate')";
                    if (mysqli_query($conn, $sql2)) {
                        logi($nazwa, "DODANIE KATEGORII",$conn);
                        echo "<script>alert('Kategoria dodana')</script>";
                    }
    } else echo "<script>alert('ni ma')</script>";
}

    if(isset($_POST['dodajpost'])){
        $tytul = $_POST['title'];
        $tresc = $_POST['tresc'];
        $id = $_POST['kategoriaid'];
        $sql2 = "INSERT INTO content_items (category_id,title,content,created_at)
        VALUES ($id,'$tytul','$tresc',NOW())";
        if($id == "wsad"){
            echo "<script>alert('Wybierz kategorie postu')</script>"; 
        }else{
        if (mysqli_query($conn, $sql2)) {
            logi($nazwa, "DODANIE POSTU",$conn);
            echo "<script>alert('Post dodany')</script>";
        }
    }}
    
?>

<html lang="pl">
<head>
    <?php
        if($alert) echo $alert;
        if ($show) {
            echo "<style>.show {
                display: none;
            }</style>";
        }
    ?>
    <style>.show {
                display: none;
            }</style>
  <meta charset="utf-8" />
  <title>Secure Content Manager - Główna
  </title>
  <link rel="icon" type="image/x-icon" href="/rosources/img/ikona.ico">
  <link href="/rosources/style/style1.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css">
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.9/css/unicons.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
  <header>
    <div id="stars"></div>
    <div id="stars2"></div>
    <div id="stars3"></div>
    <main class="inner-header flex">
            <div class="swiper">
              <div class="swiper-wrapper">
                <div class="swiper-slide swiper-slide--one">
                    <h4 class="mb-3 mt-5">TWÓJ PROFIL
                    </h4>
                    <img class="mb-2 mt-3" src="/rosources/img/awatar.jpg" alt="rzecz">
                    <p class="wiadomosc mb-2 mt-3"><?php
                        
                        if(isset($_SESSION['userName'])) echo $nazwa;
                        ?></p>

                    
                    <p class="wiadomosc mb-2 mt-3"><?php


                    $sql = "SELECT email from users where username = '$nazwa';";
                    $result = mysqli_query($conn, $sql);
                    //get data from query
                    while ($row = mysqli_fetch_row($result)) {
                        echo $row[0];
                    }

                    ?>
                    </p>
                    <button class="btn mb-2 mt-4" type="submit">ZMIEŃ HASŁO</button>
                    <a href="/ini/logout.ini.php"><button class="btn mb-5 mt-4">WYLOGUJ</button></a>
                    
                </div>
                <div class="swiper-slide swiper-slide--two" class="show">
                    <h4 class="mb-2 mt-5">DODAWANIE POSTÓW
                    </h4>
                    <form action="/main_files/index.php" method="post">
                        <input type="text" class="form-style1 mb-2 mt-3" name="title" placeholder="Tytuł">
                        <textarea class="form-style1 mb-2 mt-2" placeholder="Treść" name="tresc" id="tresc" cols="30" rows="10"></textarea>
                        <select class="form-style1 mb-2 mt-2" name="kategoriaid" id="">
                            <option disabled selected hidden value="wsad">WYBIERZ KATEGORIE</option>
                            <?php
                            $sql1 = "SELECT * from content_categories;";
                            $result = mysqli_query($conn, $sql1);
                            //get data from query
                            while ($row = mysqli_fetch_row($result)) {
                                echo"<option value=" . $row[0] . ">".$row[1]."</option>";
                            }
                            ?>
                        </select>
                        <button class="btn mb-2 mt-2" name="dodajpost" type="submit">Dodaj post</button>
                    </form>
                </div>
                <div class="swiper-slide swiper-slide--two">
                    <h4 class="mb-1 mt-5">EDYTOWANIE POSTÓW
                    </h4>
                    <form action="index.php" method="post">                       
                        <select class="form-style1 mb-1 mt-2" name="tytulpostaedit" id="">
                            <option disabled selected hidden value="asd">WYBIERZ TYTUŁ POSTA</option>
                            <?php
                            $sql2 = "SELECT item_id,title from content_items;";
                            $result = mysqli_query($conn, $sql2);
                            //get data from query
                            while ($row = mysqli_fetch_row($result)) {
                                echo"<option value=" . $row[0] . ">".$row[1]."</option>";
                            }
                           ?>
                        </select>

                                   <textarea class='form-style1 mb-2 mt-2'  placeholder='Treść' name='tresc' id='tresc' cols='30' rows='10'></textarea>
        
                                                   
                            <button class="btn mb-1 mt-2" name="edytujpost" type="submit">EDYTUJ POST</button>
                    </form>
                </form>
                </div>
                <div class="swiper-slide swiper-slide--five">
                    <h4 class="mb-1 mt-5">USUWANIE POSTÓW
                    </h4>
                    <form action="index.php" method="post">                       
                        <select class="form-style1 mb-2 mt-2" name="titleusunpost" id="">
                            <option disabled selected hidden value="wsad">WYBIERZ TYTUŁ POSTA</option>
                            <?php
                            $sql2 = "SELECT item_id,title from content_items;";
                            $result = mysqli_query($conn, $sql2);
                            //get data from query
                            while ($row = mysqli_fetch_row($result)) {
                                echo"<option value=" . $row[0] . ">".$row[1]."</option>";
                            }
                            ?>
                        </select>                          
                            <button class="btn mb-1 mt-2" name="usunpost" type="submit">USUŃ POST</button>
                    </form>
                </form>
                </div>
          <?php
          ?>
                <div class="swiper-slide swiper-slide--three show">
                    <h4 class="mb-2 mt-5">OGŁOSZENIA PARAFIALNE
                    </h4>
                    <div class="srodek">
                    <?php
                            $sql2 = "SELECT users.username, logs.action, logs.timestamp from logs INNER JOIN users ON users.user_id = logs.user_id;";
                            $result = mysqli_query($conn, $sql2);
                            //get data from query
                            while ($row = mysqli_fetch_row($result)) {
                                echo"<div class='log'><p class='wiadomosc mb-2 mt-3'>". $row[0] . " </p><p class='wiadomosc mb-2 mt-3'>".$row[1]." </p><p class='wiadomosc mb-2 mt-3'>".$row[2]."</p></div>";
                            }
                            ?>                     
                    </div>

                </div>
          
                <div class="swiper-slide swiper-slide--four">
                    <h4 class="mb-2 mt-5">PERMISJIE
                    </h4>
                    <form action="index.php" method="post">
                        <input type="text" class="form-style1 mb-2 mt-2" name="polelogin" placeholder="Login">
                        <input type="text" class="form-style1 mb-2 mt-2" name="poleemail" placeholder="Email">
                        <select class="form-style1 mb-2 mt-2" name="jakapermisja" id="">
                            <option disabled selected hidden value="">WYBIERZ RANGĘ</option>
                            <option value="1">ADMINISTRATOR</option>
                            <option value="0">UŻYTKOWNIK</option>
                        </select>

                        <button class="btn mb-2 mt-2" name="zmienrange" type="submit">Zmień rangę</button>
                    </form>
                </div>
          
                <div class="swiper-slide swiper-slide--five show">
                    <h4 class="mb-1 mt-5">EDYTOWANIE KATEGORII
                    </h4>
                    <form action="index.php" method="post">                       
                            <input type="text" name="dodajkat" class="form-style1 mb-2 mt-3" placeholder="Nazwa kategorii">                          
                            <button class="btn mb-0 mt-2" name="dodajkate" type="submit">Dodaj kategorie</button>
                    </form>
                    <form action="index.php" method="post">                       
                        <input type="text" name="zmienkat" class="form-style1 mb-2 mt-4 pt-4 pb-4" placeholder="Nazwa kategorii"> 
                        <select class="form-style1 mb-2 mt-1" name="idkategori" id="">
                            <option disabled selected hidden value="wsad">WYBIERZ KATEGORIE</option>
                            <?php
                            $sql1 = "SELECT category_id, category_name from content_categories;";
                            $result = mysqli_query($conn, $sql1);
                            //get data from query
                            while ($row = mysqli_fetch_row($result)) {
                                echo"<option value=" . $row[0] . ">".$row[1]."</option>";
                            }
                            ?>
                        </select>                                   
                        <button class="btn mb-1 mt-1" name="zmienkate" type="submit">Zmień nazwę kategorii</button>
                </form>
                    <form action="index.php" method="post">                       
                        <select class="form-style1 mb-2 mt-1" name="katdousun" id="">
                            <option disabled selected hidden value="dwas">WYBIERZ KATEGORIE</option>
                            <?php
                            $sql1 = "SELECT category_id, category_name from content_categories;";
                            $result = mysqli_query($conn, $sql1);
                            //get data from query
                            while ($row = mysqli_fetch_row($result)) {
                                echo"<option value=" . $row[0] . ">".$row[1]."</option>";
                            }
                            ?>
                        </select>                          
                        <button class="btn mb-2 mt-2" name="usunkat" type="submit">Usuń kategorie</button>
                </form>
                </div>
              </div>
            </div>        
    </main>
  <section>
  <svg class="fale" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
  viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
  <defs>
  <path id="fale1" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
  </defs>
  <g class="dofali">
  <use xlink:href="#fale1" x="48" y="0" fill="rgba(255,255,255,0.7)" />
  <use xlink:href="#fale1" x="48" y="3" fill="rgba(255,255,255,0.5)" />
  <use xlink:href="#fale1" x="48" y="5" fill="rgba(255,255,255,0.3)" />
  <use xlink:href="#fale1" x="48" y="7" fill="#fff" />
  </g>
  </svg>
  </section>
  </header>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/8.4.5/swiper-bundle.min.js"></script>
  <script src="/rosources/js/script.js"></script>
</body>
</html>