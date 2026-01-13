<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

include('cfg.php');
include('showpage.php');



$idp = $_GET['idp'] ?? 'glowna';


$headerHome = 'fragments/header-home.html';
$headerSub  = 'fragments/header-sub.html';
$footer     = 'fragments/footer.html';

if ($idp === '') {
    $idp = 'glowna';
    $header = $headerHome;
} else {
    $header = $headerSub;
}

$sql = "SELECT page_content 
        FROM page_list
        WHERE page_title = '$idp' 
        AND status = 1 
        LIMIT 1";

$result = mysqli_query($conn, $sql);


if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $content = $row['page_content'];
} else {
    $content = '<h2>404</h2><p>Strona nie istnieje.</p>';
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Najpiękniejsze miejsca świata</title>

    <link rel="stylesheet" href="assets/css/style.css">

    <script src="assets/js/timedate.js"></script>
    <script src="assets/js/kolorujtlo.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body onload="startclock()">

<?php include($header); ?>

<main>

<?php
if ($idp === 'glowna'):
?>
    <section>
        <h2>Witamy na stronie o najlepszych miejscach na świecie</h2>
        <p>
            Odkryj najpiękniejsze miejsca jakie są na planecie Ziemia,
            ale przez internet, bo nie masz budżetu by samemu tam polecieć.
        </p>
    </section>

    <section>
        <h3>Na stronie:</h3>
        <ul>
            <li>Najpiękniejsze miejsca z każdego kontynentu</li>
            <li>Galerie zdjęć</li>
            <li>Ciekawostki o miejscach</li>
        </ul>
    </section>
<?php endif; ?>

    <?php echo $content; ?>

</main>

<?php include($footer); ?>

</body>
</html>
