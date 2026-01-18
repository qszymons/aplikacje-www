<?php
/* =====================================================
   PLIK KONFIGURACYJNY CMS
   Wersja projektu: v1.6
   Plik: cfg.php
   -----------------------------------------------------
   Zawiera:
   - dane połączenia z bazą danych
   - dane logowania do panelu admina
   ===================================================== */


/* -----------------------------------------------------
   USTAWIENIA POŁĄCZENIA Z BAZĄ DANYCH
   ----------------------------------------------------- */
$dbhost = 'localhost';     // adres serwera MySQL
$dbuser = 'root';          // użytkownik bazy danych
$dbpass = '';              // hasło użytkownika bazy danych
$dbname = 'moja_strona';   // nazwa bazy danych


/* -----------------------------------------------------
   POŁĄCZENIE Z BAZĄ DANYCH
   ----------------------------------------------------- */
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

// Sprawdzenie poprawności połączenia
if (!$conn) {
    die('Błąd połączenia z bazą danych: ' . mysqli_connect_error());
}


/* -----------------------------------------------------
   DANE LOGOWANIA DO PANELU ADMINISTRACYJNEGO
   UWAGA:
   Jest to rozwiązanie uproszczone i niebezpieczne.
   W produkcji należy przechowywać hasła w bazie
   oraz stosować funkcje haszujące (password_hash).
   ----------------------------------------------------- */
$login = 'admin';
$pass  = 'admin';

?>
