<?php
/* =====================================================
   KOSZYK – STRONA (fallback) + lepszy wygląd
   Plik: cart.php
   ===================================================== */

error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

session_start();
require_once __DIR__ . '/cfg.php';
include 'fragments/footer.html';


/* -----------------------------------------------------
   Stałe linki nawigacyjne (zgodnie z Twoim routingiem)
   ----------------------------------------------------- */
$shopUrl = 'index.php?idp=shop';
$homeUrl = 'index.php?idp=glowna';

/* =======================
   LOGIKA KOSZYKA
   ======================= */
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

    $result  = mysqli_query($conn, $query);
    $product = mysqli_fetch_assoc($result);

    if (!$product) return;

    if (!isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] = [
            'id'       => (int)$product['id'],
            'title'    => (string)$product['title'],
            'price'    => (float)$product['price_netto'],
            'vat'      => (int)$product['vat'],
            'quantity' => 1,
        ];
    } else {
        $_SESSION['cart'][$product_id]['quantity']++;
    }
}

function removeFromCart($product_id)
{
    $product_id = (int)$product_id;

    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }
}

function updateCart($product_id, $quantity)
{
    $product_id = (int)$product_id;
    $quantity   = (int)$quantity;

    if ($quantity <= 0) {
        unset($_SESSION['cart'][$product_id]);
        return;
    }

    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity'] = $quantity;
    }
}

/* =======================
   WIDOK KOSZYKA
   ======================= */
function showCart($shopUrl, $homeUrl)
{
    $sum  = 0.0;

    $html = '
    <div class="cart-page">
      <div class="cart-page-header">
        <h2>🛒 Koszyk</h2>
        <div class="cart-actions-top">
          <a class="btn-back" href="'.htmlspecialchars($shopUrl).'">← Wróć do sklepu</a>
          <a class="btn-close" href="'.htmlspecialchars($homeUrl).'">Zamknij ✕</a>
        </div>
      </div>
    ';

    if (empty($_SESSION['cart'])) {
        $html .= '<p class="cart-empty">Koszyk jest pusty.</p></div>';
        return $html;
    }

    $html .= '<form method="post" class="cart-form">';
    $html .= '<div class="cart-items">';

    foreach ($_SESSION['cart'] as $item) {

        $price_brutto = (float)$item['price'] * (1 + ((int)$item['vat'] / 100));
        $value        = $price_brutto * (int)$item['quantity'];
        $sum         += $value;

        $html .= '
        <div class="cart-item">
          <div class="cart-item-main">
            <div class="cart-title">'.htmlspecialchars($item['title']).'</div>
            <div class="cart-meta">
              <span>Cena brutto: <b>'.number_format($price_brutto, 2).' zł</b></span>
              <span>Wartość: <b>'.number_format($value, 2).' zł</b></span>
            </div>
          </div>

          <div class="cart-item-actions">
            <label>Ilość</label>
            <input type="number"
                   name="qty['.(int)$item['id'].']"
                   value="'.(int)$item['quantity'].'"
                   min="1">

            <a class="cart-remove" href="cart.php?remove='.(int)$item['id'].'">Usuń</a>
          </div>
        </div>';
    }

    $html .= '</div>'; // .cart-items

    $html .= '
    <div class="cart-summary">
      <div class="cart-sum">Suma: <b>'.number_format($sum, 2).' zł</b></div>
      <div class="cart-buttons">
        <button type="submit" name="update" class="btn-primary">Aktualizuj koszyk</button>
        <a class="btn-secondary" href="'.htmlspecialchars($shopUrl).'">Kontynuuj zakupy</a>
      </div>
    </div>
    ';

    $html .= '</form>'; // form
    $html .= '</div>';  // .cart-page

    return $html;
}

/* =======================
   OBSŁUGA AKCJI
   ======================= */
if (isset($_GET['add'])) {
    addToCart($_GET['add']);
    header('Location: cart.php');
    exit;
}

if (isset($_GET['remove'])) {
    removeFromCart($_GET['remove']);
    header('Location: cart.php');
    exit;
}

if (isset($_POST['update']) && !empty($_POST['qty'])) {
    foreach ($_POST['qty'] as $id => $qty) {
        updateCart($id, $qty);
    }
    header('Location: cart.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Koszyk</title>

  <link rel="stylesheet" href="assets/css/style.css?v=<?= time() ?>">

  <style>
    .cart-page{max-width:1000px;margin:20px auto;background:#fff;border-radius:12px;
      box-shadow:0 6px 20px rgba(0,0,0,.08);padding:20px}
    .cart-page-header{display:flex;justify-content:space-between;align-items:center;gap:10px}
    .cart-actions-top{display:flex;gap:10px;flex-wrap:wrap}
    .btn-back,.btn-close,.btn-secondary{display:inline-block;padding:8px 12px;border-radius:8px;text-decoration:none}
    .btn-back{background:#e9f2ff;color:#005b96}
    .btn-close{background:#ffe9e9;color:#9b0000}
    .cart-empty{margin-top:15px}
    .cart-items{margin-top:15px;display:flex;flex-direction:column;gap:12px}
    .cart-item{border:1px solid #eee;border-radius:12px;padding:12px;display:flex;justify-content:space-between;gap:12px;flex-wrap:wrap}
    .cart-title{font-weight:700;margin-bottom:6px}
    .cart-meta{display:flex;gap:14px;flex-wrap:wrap;font-size:14px}
    .cart-item-actions{display:flex;align-items:center;gap:10px}
    .cart-item-actions input{width:70px;padding:6px}
    .cart-remove{color:#b00000;text-decoration:none}
    .cart-summary{margin-top:16px;border-top:1px solid #eee;padding-top:16px;display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap}
    .btn-primary{padding:10px 14px;border:0;border-radius:10px;background:#2b7cff;color:#fff;cursor:pointer}
    .btn-secondary{background:#f3f3f3;color:#333}
  </style>
</head>

<body>

<?php
if (file_exists('fragments/header-sub.html')) {
    include 'fragments/header-sub.html';
}
?>

<main>
  <?= showCart($shopUrl, $homeUrl); ?>
</main>

<?php
if (file_exists('fragments/footer.html')) {
    include 'fragments/footer.html';
}
?>

</body>
</html>
