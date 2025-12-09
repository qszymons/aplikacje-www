<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Filmy | Najpiękniejsze miejsca świata</title>

  <link rel="stylesheet" href="assets/css/style.css">
  <script src="kolorujtlo.js" type="text/javascript"></script>
  <script src="assets/js/timedate.js"></script>
</head>

<body onload="startclock()">

<header class="sub-header">
    <img src="assets/img/logo.png" alt="Logo" class="logo">
    <h1>Filmy</h1>
    <nav>
      <ul>
        <li><a href="index.html">Strona główna</a></li>
        <li><a href="about.html">O projekcie</a></li>
        <li><a href="continents.html">Kontynenty</a></li>
        <li><a href="gallery.html">Galeria</a></li>
        <li><a href="contact.html">Kontakt</a></li>
        <li><a href="filmy.php">Filmy</a></li>
      </ul>
    </nav>
</header>

<main>
  <h2>Najpiękniejsze miejsca świata – filmy</h2>
  <p>Oto zbiór trzech filmów przedstawiających niezwykłe miejsca na naszej planecie.</p>

  <div class="video-container">

    <!-- Film 1 -->
    <div class="video-box">
      <h3>7 Naturalnych Cudów Świata</h3>
      <iframe width="360" height="215"
        src="https://www.youtube.com/embed/n-J5UN2cAgs"
        title="YouTube video"
        frameborder="0"
        allowfullscreen>
      </iframe>
    </div>

    <!-- Film 2 -->
    <div class="video-box">
      <h3>Najpiękniejsze Miejsca Europy</h3>
      <iframe width="360" height="215"
        src="https://www.youtube.com/embed/0q7c3Jac56A"
        title="YouTube video"
        frameborder="0"
        allowfullscreen>
      </iframe>
    </div>

    <!-- Film 3 -->
    <div class="video-box">
      <h3>Top 10 Miejsc na Ziemi</h3>
      <iframe width="360" height="215"
        src="https://www.youtube.com/embed/0q7c3Jac56A"
        title="YouTube video"
        frameborder="0"
        allowfullscreen>
      </iframe>
    </div>

  </div>
</main>

<!-- Zmiana tła -->
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

<div id="zegarek"></div>
<div id="data"></div>

<footer>
  <p>&copy; 2025 Najpiękniejsze miejsca świata</p>
</footer>

</body>
</html>
