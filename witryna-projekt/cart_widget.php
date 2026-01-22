<?php
// cart_widget.php – mini koszyk (podgląd)
if (session_status() !== PHP_SESSION_ACTIVE) session_start();

$items = $_SESSION['cart'] ?? [];
$count = 0;
$sum = 0.0;

foreach ($items as $it) {
    $count += (int)$it['quantity'];
    $brutto = (float)$it['price'] * (1 + ((int)$it['vat'] / 100));
    $sum += $brutto * (int)$it['quantity'];
}
?>

<div id="cart-icon" onclick="toggleCartPreview()">
  🛒 <span id="cart-badge"><?= $count ?></span>
</div>

<div id="cart-preview">
  <div class="cart-preview-header">
    <b>Koszyk</b>
    <button type="button" class="cart-preview-close" onclick="toggleCartPreview()">✕</button>
  </div>

  <?php if (empty($items)): ?>
    <p class="cart-preview-empty">Koszyk jest pusty.</p>
  <?php else: ?>
    <div class="cart-preview-items">
      <?php foreach ($items as $it): 
        $brutto = (float)$it['price'] * (1 + ((int)$it['vat'] / 100));
      ?>
        <div class="cart-preview-item">
          <div class="cpi-title"><?= htmlspecialchars($it['title']) ?></div>
          <div class="cpi-meta">
            <?= (int)$it['quantity'] ?> × <?= number_format($brutto, 2) ?> zł
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="cart-preview-footer">
      <div><b>Suma:</b> <?= number_format($sum, 2) ?> zł</div>
      <a class="cart-preview-go" href="cart.php?return=<?= urlencode($_SERVER['REQUEST_URI']) ?>">Przejdź do koszyka</a>
    </div>
  <?php endif; ?>
</div>

<script>
function toggleCartPreview(){
  const el = document.getElementById('cart-preview');
  if(!el) return;
  el.classList.toggle('active');
}
</script>
