<?php
/* =====================================================
   DANE AUTORA / INFORMACYJNE
   ===================================================== */
$nr_indeksu = '175285';
$nrGrupy    = '2';

echo 'Szymon Olejnik ' . $nr_indeksu . ' grupa ' . $nrGrupy . '<br><br>';


/* =====================================================
   ZADANIE 2A
   -----------------------------------------------------
   include() oraz require_once()
   ===================================================== */
echo 'Zastosowanie metody include() <br><br>';
echo '--- ZADANIE 2A: include(), require_once() --- <br>';

/*
 * include() – dołącza plik, ale nie przerywa działania
 * require_once() – dołącza plik tylko raz, w razie błędu przerywa skrypt
 */
include('plik_testowy.php');
require_once('plik_testowy.php');


/* =====================================================
   ZADANIE 2B
   -----------------------------------------------------
   Instrukcje warunkowe: if / else / elseif / switch
   ===================================================== */
echo '<br><br>--- ZADANIE 2B: if, else, elseif, switch --- <br>';

$liczba = 5;

/* Warunek if / elseif / else */
if ($liczba > 10) {
    echo 'Większa niż 10<br>';
} elseif ($liczba == 10) {
    echo 'Równa 10<br>';
} else {
    echo 'Mniejsza niż 10<br>';
}

/* Instrukcja switch */
$kolor = 'czerwony';

switch ($kolor) {
    case 'zielony':
        echo 'Kolor to zielony<br>';
        break;

    case 'czerwony':
        echo 'Kolor to czerwony<br>';
        break;

    default:
        echo 'Nieznany kolor<br>';
}


/* =====================================================
   ZADANIE 2C
   -----------------------------------------------------
   Pętle while oraz for
   ===================================================== */
echo '<br><br>--- ZADANIE 2C: pętla while i for --- <br>';

/* Pętla while */
$i = 1;
while ($i <= 3) {
    echo 'While: ' . $i . '<br>';
    $i++;
}

/* Pętla for */
for ($j = 1; $j <= 3; $j++) {
    echo 'For: ' . $j . '<br>';
}


/* =====================================================
   ZADANIE 2D
   -----------------------------------------------------
   $_GET, $_POST, $_SESSION
   ===================================================== */

/* Uruchomienie sesji */
session_start();


/* -------------------------
   $_GET – pobieranie danych
   ------------------------- */
echo '<br><br>--- ZADANIE 2D: $_GET, $_POST, $_SESSION --- <br>';
echo 'GET example: <a href="?name=Jan">Kliknij tutaj</a><br>';

$name = filter_input(INPUT_GET, 'name', FILTER_SANITIZE_SPECIAL_CHARS);

if ($name !== null) {
    echo 'GET[name] = ' . $name . '<br>';
}


/* -------------------------
   $_POST – formularz
   ------------------------- */
echo '
<form method="post">
    <input type="text" name="tekst">
    <button type="submit">Wyślij POST</button>
</form>
';

$tekst = filter_input(INPUT_POST, 'tekst', FILTER_SANITIZE_SPECIAL_CHARS);

if (!empty($tekst)) {
    echo 'POST: ' . $tekst . '<br>';
}


/* -------------------------
   $_SESSION – sesja
   ------------------------- */
$_SESSION['test'] = 'To jest sesja';
echo 'SESSION: ' . $_SESSION['test'] . '<br>';
?>
