<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

$idp = $_GET['idp'] ?? '';

$baseDir = 'html/';
$headerHome = 'fragments/header-home.html';
$headerSub = 'fragments/header-sub.html';
$footer = 'fragments/footer.html';

// Wybór strony
if ($idp === '') {
    $page = $baseDir . 'glowna.html';
    $header = $headerHome;
} else {
    $page = $baseDir . $idp . '.html';
    $header = $headerSub;
}

if (!file_exists($page)) {
    $page = $baseDir . 'error404.html';
    $header = $headerSub;
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Najpiękniejsze miejsca świata</title>

    <!-- Style -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Skrypty globalne -->
    <script src="assets/js/timedate.js"></script>
    <script src="assets/js/kolorujtlo.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body onload="startclock()">

<?php include($header); ?>

<main>

<?php if ($idp === ''): ?>

    <section>
      <h2>Witamy na stronie o najlepszych miejscach na świecie</h2>
      <p>Odkryj najpiękniejsze miejsca jakie są na planecie ziemia, ale przez internet, bo nie masz budżetu by samemu tam polecieć.</p>
    </section>

    <section>
      <h3>Na stronie:</h3>
      <ul>
        <li>Najpiękniejsze miejsca z każdego kontynentu na świecie</li>
        <li>Galerie zdjęć z tych miejsc</li>
        <li>Ciekawostki o danych miejscach</li>
      </ul>
    </section>

<?php endif; ?>

    <?php include($page); ?>

</main>

<?php include($footer); ?>

</body>
</html>
