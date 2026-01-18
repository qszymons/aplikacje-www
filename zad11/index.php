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


/* =====================================================
   OBSŁUGA PARAMETRU GET ?idp=
   -----------------------------------------------------
   Zabezpieczenie przed code injection oraz XSS
   ===================================================== */
$idp = filter_input(INPUT_GET, 'idp', FILTER_SANITIZE_SPECIAL_CHARS);
$idp = $idp ?: 'glowna';


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
    <section>
        <h2>Witamy na stronie o najlepszych miejscach na świecie</h2>
        <p>
            Odkryj najpiękniejsze miejsca jakie są na planecie Ziemia,
            ale przez internet, bo nie masz budżetu by samemu tam polecieć.
        </p>
    </section>

    <section>
        <h3>Na stronie:</h3>
        <ul>
            <li>Najpiękniejsze miejsca z każdego kontynentu</li>
            <li>Galerie zdjęć</li>
            <li>Ciekawostki o miejscach</li>
        </ul>
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
<?php include($footer); ?>

</body>
</html>
