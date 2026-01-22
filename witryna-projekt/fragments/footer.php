<?php include 'cart_view.php'; ?>

<div class="bg-change">
    <p>Zmień kolor tła:</p>
    <button onclick="changeBackground('#FFFFFF')">Biały</button>
    <button onclick="changeBackground('#C0C0C0')">Szary</button>
    <button onclick="changeBackground('#000000')">Czarny</button>
    <button onclick="changeBackground('#00A0FF')">Niebieski</button>
    <button onclick="changeBackground('#00FF88')">Zielony</button>
    <button onclick="changeBackground('#FFCC00')">Żółty</button>
    <button onclick="changeBackground('#FF0000')">Czerwony</button>
</div>

<!-- TOAST -->
<div id="logo-toast">
    lepsze logo w paincie, niż generowane <br>
    <small>(przynajmniej chyba)</small>
</div>

<script>
function toggleCart() {
    document.getElementById("cart-panel")?.classList.toggle("active");
}

/* GLOBALNA FUNKCJA – działa z onclick w HTML */
function showLogoToast() {
    const toast = document.getElementById('logo-toast');
    if (!toast) return;

    toast.classList.add('show');

    clearTimeout(window.__logoToastTimer);
    window.__logoToastTimer = setTimeout(() => {
        toast.classList.remove('show');
    }, 3000);
}
</script>
