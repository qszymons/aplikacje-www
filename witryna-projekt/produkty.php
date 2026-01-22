<?php
/* =====================================================
   SYSTEM ZARZĄDZANIA PRODUKTAMI – CMS
   ===================================================== */

require_once 'cfg.php';


/* =====================================================
   DODAWANIE PRODUKTU
   ===================================================== */
function DodajProdukt()
{
    global $conn;

    if (isset($_POST['add_product'])) {

        $title       = mysqli_real_escape_string($conn, $_POST['title']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $price       = floatval($_POST['price_netto']);
        $vat         = intval($_POST['vat']);
        $stock       = intval($_POST['stock']);
        $status      = isset($_POST['status']) ? 1 : 0;
        $category    = intval($_POST['category_id']);
        $size        = mysqli_real_escape_string($conn, $_POST['size']);
        $image       = mysqli_real_escape_string($conn, $_POST['image']);

        mysqli_query($conn, "
            INSERT INTO products
            (title, description, created_at, price_netto, vat, stock, status, category_id, size, image)
            VALUES
            ('$title', '$description', NOW(), $price, $vat, $stock, $status, $category, '$size', '$image')
        ");

        echo '<p style="color:green">✔ Produkt dodany</p>';
    }

    echo '
    <h2>Dodaj produkt</h2>
    <form method="post">
        Nazwa:<br>
        <input type="text" name="title" required><br><br>

        Opis:<br>
        <textarea name="description" required></textarea><br><br>

        Cena netto:<br>
        <input type="number" step="0.01" name="price_netto" required><br><br>

        VAT (%):<br>
        <input type="number" name="vat" value="23"><br><br>

        Ilość w magazynie:<br>
        <input type="number" name="stock"><br><br>

        Kategoria:<br>
        <select name="category_id">'.ListaKategoriiSelect().'</select><br><br>

        Gabaryt:<br>
        <input type="text" name="size"><br><br>

        Link do zdjęcia:<br>
        <input type="text" name="image"><br><br>

        <label><input type="checkbox" name="status" checked> Aktywny</label><br><br>

        <input type="submit" name="add_product" value="Dodaj produkt">
    </form><hr>';
}

/* =====================================================
   LISTA PRODUKTÓW
   ===================================================== */
function PokazProdukty()
{
    global $conn;

    $res = mysqli_query($conn, "
        SELECT p.*, c.nazwa AS category
        FROM products p
        LEFT JOIN categories c ON p.category_id = c.id
        ORDER BY p.created_at DESC
    ");

    echo '<h2>Lista produktów</h2><table border="1" cellpadding="5">
        <tr>
            <th>ID</th>
            <th>Nazwa</th>
            <th>Cena</th>
            <th>Magazyn</th>
            <th>Status</th>
            <th>Akcje</th>
        </tr>';

    while ($p = mysqli_fetch_assoc($res)) {

        $available =
            ($p['status'] == 1 &&
             $p['stock'] > 0 &&
             ($p['expires_at'] === null || strtotime($p['expires_at']) > time()))
            ? 'DOSTĘPNY'
            : 'NIEDOSTĘPNY';

        echo '<tr>
            <td>'.$p['id'].'</td>
            <td>'.$p['title'].'</td>
            <td>'.$p['price_netto'].' zł</td>
            <td>'.$p['stock'].'</td>
            <td>'.$available.'</td>
            <td>
                <a href="?delete_product='.$p['id'].'">Usuń</a>
            </td>
        </tr>';
    }

    echo '</table>';
}

/* =====================================================
   USUWANIE PRODUKTU
   ===================================================== */
function UsunProdukt($id)
{
    global $conn;
    $id = intval($id);

    mysqli_query($conn, "DELETE FROM products WHERE id=$id LIMIT 1");
    echo '<p style="color:red">✖ Produkt usunięty</p>';
}

/* =====================================================
   FUNKCJA ZBIORCZA
   ===================================================== */
function ZarzadzajProduktami()
{
    ob_start();

    if (isset($_GET['delete_product'])) {
        UsunProdukt($_GET['delete_product']);
    }

    DodajProdukt();
    PokazProdukty();

    return ob_get_clean();
}
