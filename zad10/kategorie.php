<?php
/* =====================================================
   SYSTEM ZARZĄDZANIA KATEGORIAMI
   -----------------------------------------------------
   XAMPP + phpMyAdmin + mysqli
   ===================================================== */

include('cfg.php'); // połączenie z bazą

/* =====================================================
   DODAWANIE KATEGORII
   ===================================================== */
function DodajKategorie()
{
    global $conn;

    if (isset($_POST['add_category'])) {

        $nazwa = mysqli_real_escape_string($conn, $_POST['nazwa']);
        $matka = intval($_POST['matka']);

        mysqli_query(
            $conn,
            "INSERT INTO categories (matka, nazwa)
             VALUES ($matka, '$nazwa')"
        );

        echo '<p style="color:green">✔ Kategoria dodana</p>';
    }

    echo '
    <h2>Dodaj kategorię</h2>
    <form method="post">
        Nazwa:<br>
        <input type="text" name="nazwa" required><br><br>

        Kategoria nadrzędna:<br>
        <select name="matka">
            <option value="0">— Kategoria główna —</option>
            '.ListaKategoriiSelect().'
        </select><br><br>

        <input type="submit" name="add_category" value="Dodaj">
    </form><hr>';
}

/* =====================================================
   LISTA KATEGORII DO SELECTA
   ===================================================== */
function ListaKategoriiSelect()
{
    global $conn;
    $html = '';

    $res = mysqli_query($conn, "SELECT id, nazwa FROM categories WHERE matka = 0");

    while ($row = mysqli_fetch_assoc($res)) {
        $html .= '<option value="'.$row['id'].'">'.$row['nazwa'].'</option>';
    }

    return $html;
}

/* =====================================================
   USUWANIE KATEGORII
   ===================================================== */
function UsunKategorie($id)
{
    global $conn;
    $id = intval($id);

    mysqli_query($conn, "DELETE FROM categories WHERE matka = $id");
    mysqli_query($conn, "DELETE FROM categories WHERE id = $id LIMIT 1");

    echo '<p style="color:red">✖ Kategoria usunięta</p>';
}

/* =====================================================
   WYŚWIETLANIE DRZEWA KATEGORII
   ===================================================== */
function PokazKategorie()
{
    global $conn;

    echo '<h2>Drzewo kategorii</h2><ul>';

    $res = mysqli_query($conn, "SELECT * FROM categories WHERE matka = 0");

    while ($matka = mysqli_fetch_assoc($res)) {

        echo '<li><b>'.$matka['nazwa'].'</b>
            <a href="?delete='.$matka['id'].'">[usuń]</a>';

        $sub = mysqli_query(
            $conn,
            "SELECT * FROM categories WHERE matka = ".$matka['id']
        );

        if (mysqli_num_rows($sub) > 0) {
            echo '<ul>';

            while ($dziecko = mysqli_fetch_assoc($sub)) {
                echo '<li>'.$dziecko['nazwa'].'
                    <a href="?delete='.$dziecko['id'].'">[usuń]</a>
                </li>';
            }

            echo '</ul>';
        }

        echo '</li>';
    }

    echo '</ul>';
}

/* =====================================================
   LOGIKA STRONY
   ===================================================== */

/* =====================================================
   FUNKCJA ZBIORCZA – PANEL ZARZĄDZANIA KATEGORIAMI
   ===================================================== */
function ZarzadzajKategoriami()
{
    ob_start();

    // obsługa usuwania kategorii
    if (isset($_GET['delete'])) {
        UsunKategorie($_GET['delete']);
    }

    // formularz + lista kategorii
    DodajKategorie();
    PokazKategorie();

    return ob_get_clean();
}

