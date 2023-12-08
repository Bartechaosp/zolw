<?php 
  session_start();

  function error($error) {
    if ($error[0] == "success") {
      $message = $error;
      echo "<p style='color: green;'>" . $error[1] . "</p>"; 
    } else {
    $message = $error[1];
    echo "<p style='color: red;'>$message</p>"; 
    }
    unset($_SESSION['error']);
  }
?>
<html lang="pl">
<head>
  <meta charset="utf-8" />
  <title>Secure Content Manager - Logowanie i Rejestracja</title>
  <link rel="icon" type="image/x-icon" href="/rosources/img/ikona.ico">
  <link href="/rosources/style/style.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.9/css/unicons.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css">
  <script defer src="/rosources/js/walidacja.js"></script>
</head>
<body>
  <header>
    <div id="stars"></div>
    <div id="stars2"></div>
    <div id="stars3"></div>
  <main class="inner-header flex">
            <div class="sekcja pb-5 pt-5 pt-sm-2 text-center">
              <h6 class="mb-0 pb-3"><span>Zaloguj się </span><span>Zarejestruj się</span></h6>
              <input class="checkbox" type="checkbox" id="rej-log" name="rej-log" />
              <label for="rej-log"></label>
              <div class="karta-3d-wrap mx-auto">
                <div class="karta-3d-wrapper">
                  <div class="karta-front">
                    <div class="center-wrap">
                    <?php
                      if(isset($_SESSION['error'])) {
                        error($_SESSION['error']);
                      }
                      ?>
                      <div class="sekcja text-center">
                        <form action="/ini/login.ini.php" id="formularz" method="post">
                        <h4 class="mb-4 pb-3">Logowanie
                        </h4>
                        <div class="form-grupa">
                          <input type="text" id="loginlog" name="login" class="form-style" placeholder="Login">
                          <i class="input-icon uil uil-user"></i>
                        </div>
                        <!-- <div class="form-grupa mt-2">
                          <input type="password" id="haslolog" name="pass" class="form-style" placeholder="Hasło">
                          <i class="input-icon uil uil-lock-alt"></i>
                        </div> -->
                        <button type="button" class="btn mt-4" id="send" onclick="sprawdzenie()">Zaloguj się</button>
                      </form>
                        <p class="mb-0 text-center"><a href="#" class="link">Oblokuj konto</a></p>
                      </div>
                    </div>
                  </div>
                  <div class="karta-back">
                    <div class="center-wrap">
                      <div class="sekcja text-center">
                        <form action="" id="formularz1" method="post">
                          <h4 class="mt-2 mb-3 pb-3">Rejestracja</h4>
                          <div class="form-grupa">
                            <input type="text" class="form-style" name="Login" placeholder="Login" id="loginrej">
                            <i class="input-icon uil uil-user"></i>
                          </div>
                          <div class="form-grupa mt-2">
                            <input type="text" class="form-style" name="email" placeholder="Email" id="emailrej">
                            <i class="input-icon uil uil-at"></i>
                          </div>
                          <div class="form-grupa mt-2">
                            <input type="password" class="form-style" name="haslo" placeholder="Hasło" id="haslorej">
                            <i class="input-icon uil uil-lock-alt"></i>
                          </div>
                          <button type="button" class="btn mt-4" onclick="sprawdzenie()" id="send">Zarejestruj się</button>
                        </form>
                      </div>
                    </div>
                  </div>
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
</body>
</html>
