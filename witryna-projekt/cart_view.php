<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* ==========================
   Licznik (suma sztuk)
   ========================== */
$cartCount = 0;
if (!empty($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $cartCount += (int)($item['quantity'] ?? 0);
    }
}
?>

<div id="cart-panel">
    <h2>🛒 Twój koszyk</h2>

    <?php if (empty($_SESSION['cart'])): ?>
        <p>Koszyk jest pusty.</p>
        <button type="button" onclick="toggleCart()">Zamknij</button>

    <?php else: ?>
        <form method="post" action="">
            <?php
            $sum = 0.0;

            foreach ($_SESSION['cart'] as $item):
                $price   = (float)($item['price'] ?? 0);
                $vat     = (int)($item['vat'] ?? 0);
                $qty     = (int)($item['quantity'] ?? 1);
                $id      = (int)($item['id'] ?? 0);

                $brutto = $price * (1 + $vat / 100);
                $value  = $brutto * $qty;
                $sum   += $value;
            ?>
                <div class="cart-item">
                    <b><?= htmlspecialchars($item['title'] ?? 'Produkt') ?></b><br>

                    <?= number_format($brutto, 2) ?> zł
                    x
                    <input type="number" name="qty[<?= $id ?>]" value="<?= $qty ?>" min="1">

                    <a href="?remove=<?= $id ?>" title="Usuń">❌</a>
                </div>
            <?php endforeach; ?>

            <hr>
            <b>Suma: <?= number_format($sum, 2) ?> zł</b><br><br>

            <button type="submit" name="update">Aktualizuj</button>
            <button type="button" onclick="toggleCart()">Zamknij</button>
        </form>
    <?php endif; ?>
</div>

<div id="cart-icon" onclick="toggleCart()">
    🛒 <span class="cart-count"><?= $cartCount ?></span>
</div>
