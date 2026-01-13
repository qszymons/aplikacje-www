<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'moja_strona';

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if (!$conn) {
    die('Błąd połączenia z bazą danych: ' . mysqli_connect_error());
}

$login = 'admin';
$pass  = 'admin';
?>
