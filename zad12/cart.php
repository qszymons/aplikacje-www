<?php
/* =====================================================
   PROSTY KOSZYK SKLEPOWY OPARTY O $_SESSION
   ===================================================== */

session_start();
include('cfg.php');

/* =====================================================
   DODAWANIE PRODUKTU DO KOSZYKA
   ===================================================== */
function addToCart($product_id)
{
    global $conn;
    $product_id = (int)$product_id;

    $query = "
        SELECT id, title, price_netto, vat
        FROM products
        WHERE id = $product_id
        LIMIT 1
    ";

    $result = mysqli_query($conn, $query);
    $product = mysqli_fetch_assoc($result);

    if (!$product) return;

    if (!isset($_SESSION['cart'][$product_id])) {

        $_SESSION['cart'][$product_id] = [
            'id'       => $product['id'],
            'title'    => $product['title'],
            'price'    => $product['price_netto'],
            'vat'      => $product['vat'],
            'quantity' => 1
        ];

    } else {
        $_SESSION['cart'][$product_id]['quantity']++;
    }
}

/* =====================================================
   USUWANIE PRODUKTU Z KOSZYKA
   ===================================================== */
function removeFromCart($product_id)
{
    $product_id = (int)$product_id;

    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }
}

/* =====================================================
   AKTUALIZACJA ILOŚCI PRODUKTU
   ===================================================== */
function updateCart($product_id, $quantity)
{
    $product_id = (int)$product_id;
    $quantity   = (int)$quantity;

    if ($quantity <= 0) {
        unset($_SESSION['cart'][$product_id]);
    } else {
        $_SESSION['cart'][$product_id]['quantity'] = $quantity;
    }
}

/* =====================================================
   WYŚWIETLANIE KOSZYKA
   ===================================================== */
function showCart()
{
    if (empty($_SESSION['cart'])) {
        return '<p>Koszyk jest pusty.</p>';
    }

    $html = '
    <h2>🛒 Koszyk</h2>
    <form method="post">
    <table border="1" cellpadding="5">
        <tr>
            <th>Produkt</th>
            <th>Cena brutto</th>
            <th>Ilość</th>
            <th>Wartość</th>
            <th>Akcja</th>
        </tr>';

    $sum = 0;

    foreach ($_SESSION['cart'] as $item) {

        $price_brutto = $item['price'] * (1 + $item['vat'] / 100);
        $value        = $price_brutto * $item['quantity'];
        $sum         += $value;

        $html .= '
        <tr>
            <td>'.$item['title'].'</td>
            <td>'.number_format($price_brutto, 2).' zł</td>
            <td>
                <input type="number" name="qty['.$item['id'].']"
                       value="'.$item['quantity'].'" min="1">
            </td>
            <td>'.number_format($value, 2).' zł</td>
            <td>
                <a href="?remove='.$item['id'].'">Usuń</a>
            </td>
        </tr>';
    }

    $html .= '
        <tr>
            <td colspan="3"><b>SUMA</b></td>
            <td colspan="2"><b>'.number_format($sum, 2).' zł</b></td>
        </tr>
    </table><br>

    <input type="submit" name="update" value="Aktualizuj koszyk">
    </form>';

    return $html;
}

/* =====================================================
   OBSŁUGA AKCJI
   ===================================================== */

if (isset($_GET['add'])) {
    addToCart($_GET['add']);
}

if (isset($_GET['remove'])) {
    removeFromCart($_GET['remove']);
}

if (isset($_POST['update'])) {
    foreach ($_POST['qty'] as $id => $qty) {
        updateCart($id, $qty);
    }
}

echo showCart();
