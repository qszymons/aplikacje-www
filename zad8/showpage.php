<?php
function PokazPodstrone($id)
{
    global $link;

    // zabezpieczenie danych
    $id_clear = mysqli_real_escape_string($link, $id);

    $query = "SELECT page_content 
              FROM page_list 
              WHERE page_title = '$id_clear' 
              AND status = 1 
              LIMIT 1";

    $result = mysqli_query($link, $query);

    if (!$result || mysqli_num_rows($result) == 0) {
        return '<h2>404</h2><p>Nie znaleziono strony.</p>';
    }

    $row = mysqli_fetch_assoc($result);
    return $row['page_content'];
}
?>
