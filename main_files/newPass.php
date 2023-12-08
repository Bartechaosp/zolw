<?php
  session_start();

  //display an error
  function error($error) {
    echo "<p style='color: red';>$error</p>";
    unset($_SESSION['error']);
  }

  //Check type of operation
  if (isset($_GET['type']) && isset($_SESSION['iv'])) {
    $type = htmlspecialchars($_GET['type']);
    $iv = $_SESSION['iv'];
    $encrypted_type = openssl_decrypt($type, "AES-128-CTR", "rzeczINoga", 0, $iv);
    
    if ($encrypted_type == "pass") {
      $passChange = true;
    } else if ($encrypted_type == "lock") {
      $lock = true;
    } else header("Location: login.php");
  } else header("Location: login.php");
?>

<html lang="pl">
<head>
  <meta charset="utf-8" />
  <title>Secure Content Manager - Zmiana hasła</title>
  <link rel="icon" type="image/x-icon" href="/rosources/img/ikona.ico">
  <link href="/rosources/style/style.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.9/css/unicons.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
  <header>
    <div id="stars"></div>
    <div id="stars2"></div>
    <div id="stars3"></div>
    <main class="inner-header flex">
          <div class="karta-3d-wrap mx-auto">
            <div class="karta-3d-wrapper">
              <div class="karta-front">
                <div class="center-wrap">
                  <div class="sekcja text-center">
                    <?php echo "<form action='/ini/new_pass.ini.php?type=$type' method='post'>";?>
                    <h4 class="mb-4 pb-3">Zmiana hasła
                    </h4>
                    <?php if(isset($_SESSION['error'])) error($_SESSION['error']); ?>
                    <div class="form-grupa">
                      <input type="password" class="form-style" placeholder="Hasło" name="pass">
                      <i class="input-icon uil uil-lock-alt"></i>
                    </div>
                    <div class="form-grupa mt-2">
                        <input type="password" class="form-style" placeholder="Powtórz hasło" name="passv2">
                        <i class="input-icon uil uil-lock-alt"></i>
                      </div>
                    <button type="submit" class="btn mt-4" name="send">Zmień hasło</button>
                  </form>
                  <?php 
                    if ($lock) {
                      echo "<p class='mb-0 mt-4 text-center'><a class='link' href='email.php'>Odblokuj konto</a></p>";
                    }
                  ?>
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