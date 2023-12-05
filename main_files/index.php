<?php
    session_start();
    if(!isset($_SESSION['loggedIn']) && !isset($_SESSION['userName'])) {
        header("Location: /main_files/login.php");
    }
?>

<html lang="pl">
<head>
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
                    <img class="mb-2 mt-3" src="awatar.jpg" alt="">
                    <p class="wiadomosc mb-2 mt-3"><?php
                        if(isset($_SESSION['userName'])) echo $_SESSION['userName'];?></p>
                    <p class="wiadomosc mb-2 mt-3">ADMIN@CONTENTMANAGER.COM</p>
                    <button class="btn mb-2 mt-4" type="submit">ZMIEŃ HASŁO</button>
                    <a href="ini/logout.ini.php"><button class="btn mb-5 mt-4">WYLOGUJ</button></a>
                    
                </div>
                <div class="swiper-slide swiper-slide--two">
                    <h4 class="mb-2 mt-5">DODAWANIE POSTÓW
                    </h4>
                    <form action="" method="post">
                        <input type="text" class="form-style1 mb-2 mt-3" placeholder="Tytuł">
                        <textarea class="form-style1 mb-2 mt-2" placeholder="Treść" name="tresc" id="tresc" cols="30" rows="10"></textarea>
                        <select class="form-style1 mb-2 mt-2" name="" id="">
                            <option disabled selected hidden value="">WYBIERZ KATEGORIE</option>
                            <option value="">KATEGORIA 1</option>
                            <option value="">KATEGORIA 2</option>
                            <option value="">KATEGORIA 3</option>
                            <option value="">KATEGORIA 4</option>
                            <option value="">KATEGORIA 5</option>
                        </select>
                        <button class="btn mb-2 mt-2" type="submit">Dodaj post</button>
                    </form>
                </div>
                <div class="swiper-slide swiper-slide--two">
                    <h4 class="mb-1 mt-5">EDYTOWANIE POSTÓW
                    </h4>
                    <form action="" method="post">                       
                        <select class="form-style1 mb-2 mt-2" name="" id="">
                            <option disabled selected hidden value="">WYBIERZ TYTUŁ POSTA</option>
                            <option value="">TYTUŁ 1</option>
                            <option value="">TYTUŁ 2</option>
                        </select>
                        <textarea class="form-style1 mb-2 mt-2"  placeholder="Treść" name="tresc" id="tresc" cols="30" rows="10"></textarea>                          
                            <button class="btn mb-1 mt-2" type="submit">EDYTUJ POST</button>
                    </form>
                </form>
                </div>
                <div class="swiper-slide swiper-slide--five">
                    <h4 class="mb-1 mt-5">USUWANIE POSTÓW
                    </h4>
                    <form action="" method="post">                       
                        <select class="form-style1 mb-2 mt-2" name="" id="">
                            <option disabled selected hidden value="">WYBIERZ TYTUŁ POSTA</option>
                            <option value="">TYTUŁ 1</option>
                            <option value="">TYTUŁ 2</option>
                        </select>                          
                            <button class="btn mb-1 mt-2" type="submit">USUŃ POST</button>
                    </form>
                </form>
                </div>
          
                <div class="swiper-slide swiper-slide--three">
                    <h4 class="mb-2 mt-5">LOGI
                    </h4>
                    <div class="srodek">
                        <div class="log"><p class="wiadomosc mb-2 mt-3"> LOGIN </p><p class="wiadomosc mb-2 mt-3"> CZYNNOŚĆ </p><p class="wiadomosc mb-2 mt-3"> DATA </p></div>
                        <div class="log"><p class="wiadomosc mb-2 mt-3"> LOGIN </p><p class="wiadomosc mb-2 mt-3"> CZYNNOŚĆ </p><p class="wiadomosc mb-2 mt-3"> DATA </p></div>
                        <div class="log"><p class="wiadomosc mb-2 mt-3"> LOGIN </p><p class="wiadomosc mb-2 mt-3"> CZYNNOŚĆ </p><p class="wiadomosc mb-2 mt-3"> DATA </p></div>
                        <div class="log"><p class="wiadomosc mb-2 mt-3"> LOGIN </p><p class="wiadomosc mb-2 mt-3"> CZYNNOŚĆ </p><p class="wiadomosc mb-2 mt-3"> DATA </p></div>
                        <div class="log"><p class="wiadomosc mb-2 mt-3"> LOGIN </p><p class="wiadomosc mb-2 mt-3"> CZYNNOŚĆ </p><p class="wiadomosc mb-2 mt-3"> DATA </p></div>
                        <div class="log"><p class="wiadomosc mb-2 mt-3"> LOGIN </p><p class="wiadomosc mb-2 mt-3"> CZYNNOŚĆ </p><p class="wiadomosc mb-2 mt-3"> DATA </p></div>                       
                    </div>

                </div>
          
                <div class="swiper-slide swiper-slide--four">
                    <h4 class="mb-2 mt-5">PERMISJIE
                    </h4>
                    <form action="" method="post">
                        <input type="text" class="form-style1 mb-2 mt-2" placeholder="Login">
                        <input type="text" class="form-style1 mb-2 mt-2" placeholder="Email">
                        <select class="form-style1 mb-2 mt-2" name="" id="">
                            <option disabled selected hidden value="">WYBIERZ RANGĘ</option>
                            <option value="">ADMINISTRATOR</option>
                            <option value="">UŻYTKOWNIK</option>
                        </select>

                        <button class="btn mb-2 mt-2" type="submit">Zmień rangę</button>
                    </form>
                </div>
          
                <div class="swiper-slide swiper-slide--five">
                    <h4 class="mb-1 mt-5">EDYTOWANIE KATEGORII
                    </h4>
                    <form action="" method="post">                       
                            <input type="text" name="dodajkat" class="form-style1 mb-2 mt-3" placeholder="Nazwa kategorii">                          
                            <button class="btn mb-1 mt-2" type="submit">Dodaj kategorie</button>
                    </form>
                    <form action="" method="post">                       
                        <input type="text" name="dodajkat" class="form-style1 mb-2 mt-2" placeholder="Nazwa kategorii"> 
                        <select class="form-style1 mb-2 mt-1" name="" id="">
                            <option disabled selected hidden value="">WYBIERZ KATEGORIE</option>
                            <option value="">KATEGORIA 1</option>
                            <option value="">KATEGORIA 2</option>
                            <option value="">KATEGORIA 3</option>
                            <option value="">KATEGORIA 4</option>
                            <option value="">KATEGORIA 5</option>
                        </select>                                   
                        <button class="btn mb-1 mt-1" type="submit">Zmień nazwę kategorii</button>
                </form>
                    <form action="" method="post">                       
                        <select class="form-style1 mb-2 mt-1" name="" id="">
                            <option disabled selected hidden value="">WYBIERZ KATEGORIE</option>
                            <option value="">KATEGORIA 1</option>
                            <option value="">KATEGORIA 2</option>
                            <option value="">KATEGORIA 3</option>
                            <option value="">KATEGORIA 4</option>
                            <option value="">KATEGORIA 5</option>
                        </select>                          
                        <button class="btn mb-2 mt-2" type="submit">Usuń kategorie</button>
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