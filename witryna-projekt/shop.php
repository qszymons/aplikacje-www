<?php
/* =====================================================
   SKLEP – LISTA PRODUKTÓW (FRONTEND)
   Plik: shop.php
   ===================================================== */

error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

session_start();
require_once 'cfg.php';
require_once __DIR__ . '/cart_logic.php';
include 'fragments/footer.html';
// Zapamiętaj skąd użytkownik przyszedł (dla przycisków Wróć/Zamknij)
if (!empty($_GET['return'])) {
    $_SESSION['return_to'] = $_GET['return'];
}

// Ustal URL powrotu (fallback)
$returnUrl = $_SESSION['return_to'] ?? 'shop.php';



if (isset($_GET['add'])) addToCart($_GET['add']);
if (isset($_GET['remove'])) removeFromCart($_GET['remove']);

if (isset($_POST['update'])) {
    foreach ($_POST['qty'] as $id => $q) {
        updateCart($id, $q);
    }
}


/* -----------------------------------------------------
   Fragmenty layoutu – takie same jak w index.php
   ----------------------------------------------------- */
$header = 'fragments/header-sub.html';
$footer = 'fragments/footer.html';
$tripTypes = [
    1 => 'Wycieczka 3 dniowa (all inclusive)',
    2 => 'Wakacje 2 tygodniowe (all inclusive)',
    3 => 'Wakacje 2 tygodniowe',
    4 => 'Wycieczka 3 dniowa',
    5 => 'Wypad 1 dniowy',
    6 => 'Wypad 1 dniowy (all inclusive)',
    7 => 'Event czasowy'
];

/* -----------------------------------------------------
   Pobranie produktów z bazy
   ----------------------------------------------------- */
$sql = "
    SELECT p.*, c.nazwa AS category_name
    FROM products p
    LEFT JOIN categories c ON p.category_id = c.id
    ORDER BY p.created_at DESC
";

$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Sklep</title>

    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

<?php include($header); ?>

<main>

<h2> Sklep – dostępne produkty</h2>

<?php
if (!$result || mysqli_num_rows($result) === 0) {
    echo '<p>Brak produktów w sklepie.</p>';
} else {

    echo '<div class="shop-products">';

while ($p = mysqli_fetch_assoc($result)) {

    $isAvailable =
        $p['status'] == 1 &&
        $p['stock'] > 0 &&
        (
            empty($p['expires_at']) ||
            strtotime($p['expires_at']) > time()
        );

    if (!$isAvailable) {
        continue;
    }

    $priceNetto  = (float)$p['price_netto'];
    $vat         = (int)$p['vat'];
    $priceBrutto = round($priceNetto * (1 + $vat / 100), 2);

    echo '
    <div class="product-card">

        <h3>'.htmlspecialchars($p['title']).'</h3>
    ';

    // <<< DOKŁADNIE TUTAJ DODAJESZ >>>
    if ($p['id'] == 7) {
        echo '<p style="color:red"><b>⚠ Event czasowy – ograniczona dostępność!</b></p>';
    }

    echo '
        '.(!empty($p['image'])
            ? '<img src="'.htmlspecialchars($p['image']).'" alt="">'
            : ''
        ).'

        <p>'.nl2br(htmlspecialchars($p['description'])).'</p>

        <p><b>Kategoria:</b> '.htmlspecialchars($p['category_name']).'</p>
        <p><b>Cena brutto:</b> '.$priceBrutto.' zł</p>
        <p><b>Dostępne sztuki:</b> '.$p['stock'].'</p>

        <a href="cart.php?add='.$p['id'].'&return='.urlencode($_SERVER['REQUEST_URI']).'" class="btn-cart">Dodaj do koszyka</a>


    </div>';
}


    echo '</div>';
}
?>

</main>

<?php include($footer); ?>
<?php require_once __DIR__ . '/cart_widget.php'; ?>
<script src="assets/js/kolorujtlo.js"></script>

</body>
</html>
<?php include 'fragments/footer.php'; ?>