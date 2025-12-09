<?php
$nr_indeksu = '175285';
$nrGrupy = '2';

echo 'Szymon olejnik '.$nr_indeksu.' grupa '.$nrGrupy.' <br><br>';
echo 'Zastosowanie metody include() <br><br>';
echo '--- ZADANIE 2A: include(), require_once() --- <br>';

include('plik_testowy.php'); 
require_once('plik_testowy.php');

echo '<br><br>--- ZADANIE 2B: if, else, elseif, switch --- <br>';

$liczba = 5;

if ($liczba > 10) {
    echo 'Większa niż 10<br>';
} elseif ($liczba == 10) {
    echo 'Równa 10<br>';
} else {
    echo 'Mniejsza niż 10<br>';
}

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

echo '<br><br>--- ZADANIE 2C: pętla while i for --- <br>';

$i = 1;
while ($i <= 3) {
    echo 'While: '.$i.'<br>';
    $i++;
}

for ($j = 1; $j <= 3; $j++) {
    echo 'For: '.$j.'<br>';
}

echo '<br><br>--- ZADANIE 2D: $_GET, $_POST, $_SESSION --- <br>';

session_start();


echo 'GET example: <a href="?name=Jan">Kliknij tutaj</a><br>';
if (isset($_GET['name'])) {
    echo 'GET[name] = '.$_GET['name'].'<br>';
}


echo '
<form method="POST">
    <input name="tekst">
    <button type="submit">Wyślij POST</button>
</form>
';

if (!empty($_POST['tekst'])) {
    echo 'POST: '.$_POST['tekst'].'<br>';
}


$_SESSION['test'] = 'To jest sesja';
echo 'SESSION: '.$_SESSION['test'].'<br>';
?>

