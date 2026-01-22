
<?php
/* =====================================================
   PLIK: index.php
   -----------------------------------------------------
   Główna logika wyświetlania podstron serwisu.
   Pobiera treść stron z bazy danych na podstawie
   parametru GET ?idp=
   ===================================================== */


/* -----------------------------------------------------
   USTAWIENIA BŁĘDÓW (tylko na potrzeby developmentu)
   ----------------------------------------------------- */
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);


/* -----------------------------------------------------
   DOŁĄCZENIE PLIKÓW KONFIGURACYJNYCH
   -----------------------------------------------------
   cfg.php      – połączenie z bazą danych
   showpage.php – dodatkowe funkcje pomocnicze
   ----------------------------------------------------- */
include('cfg.php');
include('showpage.php');
$footer = 'fragments/footer.php';
require_once __DIR__ . '/cart_logic.php';


if (isset($_GET['add'])) addToCart($_GET['add']);
if (isset($_GET['remove'])) removeFromCart($_GET['remove']);

if (isset($_POST['update'])) {
    foreach ($_POST['qty'] as $id => $q) {
        updateCart($id, $q);
    }
}



/* =====================================================
   OBSŁUGA PARAMETRU GET ?idp=
   -----------------------------------------------------
   Zabezpieczenie przed code injection oraz XSS
   ===================================================== */
$idp = filter_input(INPUT_GET, 'idp', FILTER_SANITIZE_SPECIAL_CHARS);
$idp = $idp ?: 'glowna';
// Specjalne podstrony dynamiczne (nie z bazy)
if ($idp === 'shop') {
    include 'shop.php';
    exit;
}


/* =====================================================
   DEFINICJA SZABLONÓW STRONY
   ===================================================== */
$headerHome = 'fragments/header-home.html';
$headerSub  = 'fragments/header-sub.html';
$footer     = 'fragments/footer.html';


/* =====================================================
   WYBÓR NAGŁÓWKA STRONY
   -----------------------------------------------------
   Inny nagłówek dla strony głównej,
   inny dla podstron
   ===================================================== */
if ($idp === 'glowna') {
    $header = $headerHome;
} else {
    $header = $headerSub;
}


/* =====================================================
   POBRANIE TREŚCI STRONY Z BAZY DANYCH
   -----------------------------------------------------
   - LIMIT 1 – zabezpieczenie zapytania
   - status = 1 – tylko aktywne podstrony
   ===================================================== */
$idp_db = mysqli_real_escape_string($conn, $idp);

$sql = "
    SELECT page_content
    FROM page_list
    WHERE page_title = '$idp_db'
      AND status = 1
    LIMIT 1
";

$result = mysqli_query($conn, $sql);


/* =====================================================
   OBSŁUGA WYNIKU ZAPYTANIA SQL
   ===================================================== */
if ($result && mysqli_num_rows($result) === 1) {
    $row     = mysqli_fetch_assoc($result);
    $content = $row['page_content'];
} else {
    $content = '<h2>404</h2><p>Strona nie istnieje.</p>';
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <script src="assets/js/contact.js" defer></script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Najpiękniejsze miejsca świata</title>

    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Skrypty JS -->
    <script src="assets/js/timedate.js"></script>
    <script src="assets/js/kolorujtlo.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body onload="startclock()">

<!-- ==================================================
     NAGŁÓWEK STRONY
     ================================================== -->
<?php include($header); ?>

<main>

<!-- ==================================================
     DODATKOWA TREŚĆ DLA STRONY GŁÓWNEJ
     ================================================== -->
<?php if ($idp === 'glowna'): ?>

    <!-- HERO -->
    <section class="hero">
        <div class="hero-content">
            <h1>Odkrywaj Najpiękniejsze Miejsca Świata</h1>
            <p>Galerie, filmy, inspiracje i wyjazdy — wszystko w jednym miejscu.</p>

            <div class="hero-buttons">
                <a href="index.php?idp=gallery" class="btn-primary">📸 Zobacz galerię</a>
                <a href="index.php?idp=filmy" class="btn-secondary">🎬 Obejrzyj filmy</a>
                <a href="index.php?idp=shop" class="btn-secondary">🛒 Przeglądaj wyjazdy</a>
            </div>
        </div>
    </section>

    <!-- KAFELKI / FEATURES -->
    <section class="features">
        <div class="feature-card">
            <h3>📸 Galerie</h3>
            <p>Zdjęcia najpiękniejszych miejsc świata z krótkimi opisami.</p>
            <a class="feature-link" href="index.php?idp=gallery">Przejdź →</a>
        </div>

        <div class="feature-card">
            <h3>🎬 Filmy</h3>
            <p>Wideo, które inspiruje do podróży i pokazuje klimat miejsc.</p>
            <a class="feature-link" href="index.php?idp=filmy">Przejdź →</a>
        </div>

        <div class="feature-card">
            <h3>🌍 Kontynenty</h3>
            <p>Lista miejsc z podziałem na kontynenty — szybko i czytelnie.</p>
            <a class="feature-link" href="index.php?idp=continents">Przejdź →</a>
        </div>

        <div class="feature-card">
            <h3>🛒 Wyjazdy</h3>
            <p>Oferty wyjazdów: krótkie wypady, wakacje i eventy czasowe.</p>
            <a class="feature-link" href="index.php?idp=shop">Przejdź →</a>
        </div>
    </section>

    <!-- POLECANE KIERUNKI (mini-galeria) -->
    <section class="highlighted">
        <h2>Polecane kierunki</h2>

        <div class="highlighted-grid">
            <a href="https://pl.wikipedia.org/wiki/Machu_Picchu" target="_blank" rel="noopener noreferrer">
                <img src="assets/img/site_0274_0045-400-400-20251203131306.webp" alt="Machu Picchu">
                <span>Machu Picchu</span>
            </a>

            <a href="https://pl.wikipedia.org/wiki/Wielka_Rafa_Koralowa" target="_blank" rel="noopener noreferrer">
                <img src="assets/img/australie-la-grande-barriere-de-corail_928.jpg" alt="Wielka Rafa Koralowa">
                <span>Wielka Rafa Koralowa</span>
            </a>

            <a href="https://pl.wikipedia.org/wiki/Zatoka_Ha_Long" target="_blank" rel="noopener noreferrer">
                <img src="assets/img/shutterstock_1218765286_0.jpg" alt="Hạ Long Bay">
                <span>Hạ Long Bay</span>
            </a>
        </div>
    </section>

    <!-- CTA NA KONIEC -->
    <section class="cta">
        <h2>Gotowy na podróż?</h2>
        <p>Sprawdź dostępne wyjazdy i dodaj coś do koszyka.</p>
        <a href="index.php?idp=shop" class="btn-primary">Zobacz wyjazdy</a>
    </section>

<?php endif; ?>


<!-- ==================================================
     TREŚĆ PODSTRONY Z BAZY DANYCH
     ================================================== -->
<?php echo $content; ?>

</main>

<!-- ==================================================
     STOPKA
     ================================================== -->
<?php require_once __DIR__ . '/cart_widget.php'; ?>

</body>
</html>