
<?php
if (defined('CART_LOGIC_LOADED')) return;
define('CART_LOGIC_LOADED', true);

session_start();
require_once __DIR__ . '/cfg.php';


function addToCart($product_id)
{
    global $conn;
    $product_id = (int)$product_id;

    $q = "SELECT id, title, price_netto, vat FROM products WHERE id=$product_id LIMIT 1";
    $r = mysqli_query($conn, $q);
    $p = mysqli_fetch_assoc($r);

    if (!$p) return;

    if (!isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] = [
            'id' => $p['id'],
            'title' => $p['title'],
            'price' => $p['price_netto'],
            'vat' => $p['vat'],
            'quantity' => 1
        ];
    } else {
        $_SESSION['cart'][$product_id]['quantity']++;
    }
}

function removeFromCart($product_id)
{
    unset($_SESSION['cart'][(int)$product_id]);
}

function updateCart($id, $qty)
{
    if ($qty <= 0) unset($_SESSION['cart'][$id]);
    else $_SESSION['cart'][$id]['quantity'] = $qty;
}
