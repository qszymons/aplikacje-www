<?php
/* =====================================================
   FUNKCJA: PokazPodstrone()
   -----------------------------------------------------
   Odpowiedzialność:
   - pobiera treść podstrony z bazy danych
   - sprawdza czy strona jest aktywna (status = 1)
   - zabezpiecza dane wejściowe przed SQL Injection
   - zwraca treść HTML lub komunikat 404
   ===================================================== */

/**
 * Wyświetla treść podstrony na podstawie jej identyfikatora
 *
 * @param string $id – identyfikator strony (np. "glowna", "kontakt")
 * @return string – treść strony lub komunikat błędu
 */
function PokazPodstrone($id)
{
    /* ---------------------------------------------
       Dostęp do połączenia z bazą danych
       --------------------------------------------- */
    global $conn;

    /* ---------------------------------------------
       Zabezpieczenie danych wejściowych
       - usuwamy potencjalne znaki SQL Injection
       --------------------------------------------- */
    $id_clear = mysqli_real_escape_string($conn, $id);

    /* ---------------------------------------------
       Zapytanie SQL:
       - pobiera tylko jedną stronę (LIMIT 1)
       - tylko aktywne strony (status = 1)
       --------------------------------------------- */
    $query = "
        SELECT page_content
        FROM page_list
        WHERE page_title = '$id_clear'
          AND status = 1
        LIMIT 1
    ";

    $result = mysqli_query($conn, $query);

    /* ---------------------------------------------
       Obsługa błędu:
       - brak wyników
       - błąd zapytania
       --------------------------------------------- */
    if (!$result || mysqli_num_rows($result) === 0) {
        return '<h2>404</h2><p>Nie znaleziono strony.</p>';
    }

    /* ---------------------------------------------
       Pobranie treści strony
       --------------------------------------------- */
    $row = mysqli_fetch_assoc($result);

    return $row['page_content'];
}
?>
