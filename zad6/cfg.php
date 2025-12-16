<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'moja_strona';

$link = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if (!$link) {
    die('Błąd połączenia z bazą danych: ' . mysqli_connect_error());
}
?>
