-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 22, 2026 at 01:36 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `moja_strona`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `matka` int(11) DEFAULT 0,
  `nazwa` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `matka`, `nazwa`) VALUES
(1, 0, 'Wycieczka 3 dniowa all inclusive'),
(2, 0, 'Wakacje 2 tygodniowe all inclusive'),
(3, 1, 'Wakacje 2 tygodniowe'),
(4, 1, 'Wycieczka 3 dniowa'),
(5, 3, 'Wypad 1 dniowy'),
(6, 2, 'Wypad 1 dniowy all inclusive'),
(7, 2, 'Event czasowy');

-- --------------------------------------------------------

--
-- Table structure for table `page_list`
--

CREATE TABLE `page_list` (
  `id` int(11) NOT NULL,
  `page_title` varchar(255) NOT NULL,
  `page_content` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `page_list`
--

INSERT INTO `page_list` (`id`, `page_title`, `page_content`, `status`) VALUES
(1, 'about', '<h2>O projekcie</h2>\r\n\r\n<section class=\"about-block\">\r\n    <h3>Cel strony</h3>\r\n    <p>\r\n        Projekt „Najpiękniejsze miejsca świata” powstał z mojego komputera osobistego\r\n        na potrzeby studiów. Ma na celu zaprezentowanie wyjątkowych miejsc z całego świata —\r\n        zarówno tych stworzonych przez naturę, jak i dzieł architektury.\r\n    </p>\r\n</section>\r\n\r\n<section class=\"about-block\">\r\n    <h3>O czym jest ta strona?</h3>\r\n    <p>\r\n        Odkryj najpiękniejsze miejsca jakie są na planecie Ziemia,\r\n        ale przez internet, bo nie masz budżetu by samemu tam polecieć. A jak masz to też jest strona do kupna.\r\n    </p>\r\n</section>\r\n\r\n<section class=\"about-block\">\r\n    <h3>Na stronie znajdują się:</h3>\r\n    <ul>\r\n        <li>Najpiękniejsze miejsca z każdego kontynentu na świecie</li>\r\n        <li>Galerie zdjęć z tych miejsc</li>\r\n        <li>Ciekawostki o danych miejscach</li>\r\n    </ul>\r\n</section>\r\n\r\n<section class=\"about-block\">\r\n    <h3>Co przedstawiamy?</h3>\r\n    <ol>\r\n        <li>Niezwykłe dzieła natury</li>\r\n        <li>Interesujące konstrukcje architektoniczne</li>\r\n        <li>Miejsca o znaczeniu historycznym i kulturowym</li>\r\n    </ol>\r\n</section>\r\n', 1),
(2, 'contact', '<article class=\"content-section contact-page\">\r\n\r\n    <h2>Kontakt z autorem projektu</h2>\r\n\r\n    <p class=\"contact-intro\">\r\n        Jeśli chcesz podzielić się opinią, sugestią albo po prostu coś napisać —\r\n        możesz to zrobić poniżej. Czy to przeczytam? No… nie obiecuję 😉\r\n    </p>\r\n\r\n    <section class=\"contact-form\">\r\n        <h3>Napisz wiadomość</h3>\r\n\r\n        <form id=\"contactForm\" class=\"contact-form-box\">\r\n            <label>\r\n                Twój email:\r\n                <input type=\"email\" name=\"email\" required>\r\n            </label>\r\n\r\n            <label>\r\n                Temat:\r\n                <input type=\"text\" name=\"temat\" required>\r\n            </label>\r\n\r\n            <label>\r\n                Wiadomość:\r\n                <textarea name=\"tresc\" rows=\"5\" required></textarea>\r\n            </label>\r\n\r\n            <button id=\"sendBtn\" type=\"submit\" class=\"contact-btn\">\r\n                Wyślij wiadomość\r\n            </button>\r\n\r\n            <div id=\"formStatus\" class=\"form-status\" aria-live=\"polite\"></div>\r\n        </form>\r\n    </section>\r\n\r\n    <section class=\"contact-direct\">\r\n        <h3>Kontakt bezpośredni</h3>\r\n        <p>\r\n            Email:\r\n            <a href=\"mailto:madra.nazwa.na.emaila@gmail.com\">\r\n                madra.nazwa.na.emaila@gmail.com\r\n            </a>\r\n        </p>\r\n    </section>\r\n\r\n    <section class=\"contact-social\">\r\n        <h3>Sociale</h3>\r\n        <div class=\"social-links\">\r\n            <a href=\"https://www.instagram.com/\" target=\"_blank\" rel=\"noopener\">📸 Instagram</a>\r\n            <a href=\"https://www.facebook.com/\" target=\"_blank\" rel=\"noopener\">👍 Facebook</a>\r\n            <a href=\"https://github.com/qszymons/aplikacje-www\"_blank\" rel=\"noopener\">💻 GitHub</a>\r\n        </div>\r\n    </section>\r\n\r\n</article>\r\n\r\n', 1),
(3, 'continents', '<article class=\"content-section continents-page\">\r\n\r\n    <h2>Cuda świata według kontynentów</h2>\r\n\r\n    <div class=\"table-wrap\">\r\n        <table class=\"nice-table\">\r\n            <thead>\r\n                <tr>\r\n                    <th>Kontynent</th>\r\n                    <th>Najpiękniejsze miejsce</th>\r\n                    <th>Kraj</th>\r\n                </tr>\r\n            </thead>\r\n            <tbody>\r\n                <tr>\r\n                    <td>Azja</td>\r\n                    <td>\r\n                        <a href=\"https://pl.wikipedia.org/wiki/Zatoka_Ha_Long\" target=\"_blank\" rel=\"noopener\">\r\n                            Hạ Long Bay\r\n                        </a>\r\n                    </td>\r\n                    <td>Wietnam</td>\r\n                </tr>\r\n\r\n                <tr>\r\n                    <td>Europa</td>\r\n                    <td>\r\n                        <a href=\"https://en.wikipedia.org/wiki/Geirangerfjord\" target=\"_blank\" rel=\"noopener\">\r\n                            Geirangerfjord\r\n                        </a>\r\n                    </td>\r\n                    <td>Norwegia</td>\r\n                </tr>\r\n\r\n                <tr>\r\n                    <td>Ameryka Południowa</td>\r\n                    <td>\r\n                        <a href=\"https://pl.wikipedia.org/wiki/Machu_Picchu\" target=\"_blank\" rel=\"noopener\">\r\n                            Machu Picchu\r\n                        </a>\r\n                    </td>\r\n                    <td>Peru</td>\r\n                </tr>\r\n\r\n                <tr>\r\n                    <td>Ameryka Północna</td>\r\n                    <td>\r\n                        <a href=\"https://pl.wikipedia.org/wiki/Wielki_Kanion_Kolorado\" target=\"_blank\" rel=\"noopener\">\r\n                            Wielki Kanion\r\n                        </a>\r\n                    </td>\r\n                    <td>USA</td>\r\n                </tr>\r\n\r\n                <tr>\r\n                    <td>Afryka</td>\r\n                    <td>\r\n                        <a href=\"https://pl.wikipedia.org/wiki/Piramidy_w_Gizie\" target=\"_blank\" rel=\"noopener\">\r\n                            Piramidy w Gizie\r\n                        </a>\r\n                    </td>\r\n                    <td>Egipt</td>\r\n                </tr>\r\n\r\n                <tr>\r\n                    <td>Australia i Oceania</td>\r\n                    <td>\r\n                        <a href=\"https://pl.wikipedia.org/wiki/Wielka_Rafa_Koralowa\" target=\"_blank\" rel=\"noopener\">\r\n                            Wielka Rafa Koralowa\r\n                        </a>\r\n                    </td>\r\n                    <td>Australia</td>\r\n                </tr>\r\n            </tbody>\r\n        </table>\r\n    </div>\r\n\r\n</article>\r\n', 1),
(4, 'filmy', '<h2>Filmy</h2>\r\n\r\n<div class=\"video-container\">\r\n\r\n    <div class=\"video-box\">\r\n        <iframe width=\"560\" height=\"315\"\r\n            src=\"https://www.youtube.com/embed/TJjmY6E9qmc\"\r\n            frameborder=\"0\" allowfullscreen></iframe>\r\n    </div>\r\n\r\n    <div class=\"video-box\">\r\n        <iframe width=\"560\" height=\"315\"\r\n            src=\"https://www.youtube.com/embed/hOI0n5vSRUM\"\r\n            frameborder=\"0\" allowfullscreen></iframe>\r\n    </div>\r\n\r\n    <div class=\"video-box\">\r\n        <iframe width=\"560\" height=\"315\"\r\n            src=\"https://www.youtube.com/embed/rm_dpIevL4g\"\r\n            frameborder=\"0\" allowfullscreen></iframe>\r\n    </div>\r\n\r\n</div>\r\n', 1),
(5, 'gallery', '<article class=\"gallery gallery-links\">\r\n\r\n  <figure class=\"gallery-item\">\r\n    <a class=\"gallery-link\" href=\"https://pl.wikipedia.org/wiki/Zatoka_Ha_Long\" target=\"_blank\" rel=\"noopener noreferrer\">\r\n      <img src=\"assets/img/shutterstock_1218765286_0.jpg\" alt=\"Hạ Long Bay\">\r\n    </a>\r\n    <figcaption>Hạ Long Bay, Wietnam</figcaption>\r\n  </figure>\r\n\r\n  <figure class=\"gallery-item\">\r\n    <a class=\"gallery-link\" href=\"https://pl.wikipedia.org/wiki/Geirangerfjord\" target=\"_blank\" rel=\"noopener noreferrer\">\r\n      <img src=\"assets/img/93f1e40541682941ecf60fd55ce1b3824b0ac9cf-1024x576.webp\" alt=\"Geirangerfjord\">\r\n    </a>\r\n    <figcaption>Geirangerfjord, Norwegia</figcaption>\r\n  </figure>\r\n\r\n  <figure class=\"gallery-item\">\r\n    <a class=\"gallery-link\" href=\"https://pl.wikipedia.org/wiki/Machu_Picchu\" target=\"_blank\" rel=\"noopener noreferrer\">\r\n      <img src=\"assets/img/site_0274_0045-400-400-20251203131306.webp\" alt=\"Machu Picchu\">\r\n    </a>\r\n    <figcaption>Machu Picchu, Peru</figcaption>\r\n  </figure>\r\n\r\n  <figure class=\"gallery-item\">\r\n    <a class=\"gallery-link\" href=\"https://pl.wikipedia.org/wiki/Wielki_Kanion_Kolorado\" target=\"_blank\" rel=\"noopener noreferrer\">\r\n      <img src=\"assets/img/sunset-matter-point-grand-canyon-grand-canyon-national-park-_shutterstock_2142642123.webp\" alt=\"Wielki Kanion\">\r\n    </a>\r\n    <figcaption>Wielki Kanion, USA</figcaption>\r\n  </figure>\r\n\r\n  <figure class=\"gallery-item\">\r\n    <a class=\"gallery-link\" href=\"https://pl.wikipedia.org/wiki/Piramidy_w_Gizie\" target=\"_blank\" rel=\"noopener noreferrer\">\r\n      <img src=\"assets/img/Piramidy-w-Gizie-i-wielblady.jpg\" alt=\"Piramidy w Gizie\">\r\n    </a>\r\n    <figcaption>Piramidy w Gizie, Egipt</figcaption>\r\n  </figure>\r\n\r\n  <figure class=\"gallery-item\">\r\n    <a class=\"gallery-link\" href=\"https://pl.wikipedia.org/wiki/Wielka_Rafa_Koralowa\" target=\"_blank\" rel=\"noopener noreferrer\">\r\n      <img src=\"assets/img/australie-la-grande-barriere-de-corail_928.jpg\" alt=\"Wielka Rafa Koralowa\">\r\n    </a>\r\n    <figcaption>Wielka Rafa Koralowa, Australia</figcaption>\r\n  </figure>\r\n\r\n</article>\r\n', 1),
(6, 'glowna', '<section>\r\n  <h2>Witamy na stronie o najlepszych miejscach na świecie</h2>\r\n  <p>Odkryj najpiękniejsze miejsca jakie są na planecie ziemia, ale przez internet, bo nie masz budżetu by samemu tam polecieć.</p>\r\n</section>\r\n\r\n<section>\r\n  <h3>Na stronie:</h3>\r\n  <ul>\r\n    <li>Najpiękniejsze miejsca z każdego kontynentu na świecie</li>\r\n    <li>Galerie zdjęć z tych miejsc</li>\r\n    <li>Ciekawostki o danych miejscach</li>\r\n  </ul>\r\n</section>\r\n', 1),
(7, 'index', '<!DOCTYPE html>\r\n<html lang=\"pl\">\r\n<head>\r\n  <meta charset=\"UTF-8\">\r\n  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\r\n  <title>Najpiękniejsze miejsca świata</title>\r\n  <link rel=\"stylesheet\" href=\"assets/css/style.css\">\r\n    <script src=\"kolorujtlo.js\" type=\"text/javascript\"></script>\r\n <script src=\"assets/js/timedate.js\"></script>\r\n <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js\"></script>\r\n<link rel=\"stylesheet\" href=\"style.css\"/>\r\n</head>\r\n<body>\r\n\r\n  <main>\r\n    <section>\r\n      <h2>Witamy na stronie o najlepszych miejscach na świecie</h2>\r\n      <p>Odkryj najpiękniejsze miejsca jakie są na planecie ziemia, ale przez internet, bo nie masz budżetu by samemu tam polecieć.</p>\r\n    </section>\r\n\r\n    <section>\r\n      <h3>Na stronie:</h3>\r\n      <ul>\r\n        <li>Najpiękniejsze miejsca z każdego kontynentu na świecie</li>\r\n        <li>Galerie zdjęć z tych miejsc</li>\r\n        <li>Ciekawostki o danych miejscach</li>\r\n      </ul>\r\n    </section>\r\n    \r\n       <div class=\"bg-change\">\r\n        \r\n  <p>Zmień kolor tła:</p>\r\n  <button onclick=\"changeBackground(\'#FFFFFF\')\">Biały</button>\r\n  <button onclick=\"changeBackground(\'#C0C0C0\')\">Szary</button>\r\n  <button onclick=\"changeBackground(\'#000000\')\">Czarny</button>\r\n  <button onclick=\"changeBackground(\'#00A0FF\')\">Niebieski</button>\r\n  <button onclick=\"changeBackground(\'#00FF88\')\">Zielony</button>\r\n  <button onclick=\"changeBackground(\'#FFCC00\')\">Żółty</button>\r\n  <button onclick=\"changeBackground(\'#FF0000\')\">Czerwony</button>\r\n\r\n  </div>\r\n  \r\n  <footer>\r\n    <p>&copy; 2025 Najpiękniejsze miejsca świata | Projekt edukacyjny</p>\r\n  </footer>\r\n</body>\r\n</html>\r\n', 1),
(8, 'index', '<?php\r\nerror_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);\r\n\r\n$idp = $_GET[\'idp\'] ?? \'\';\r\n\r\n$baseDir = \'html/\';\r\n$headerHome = \'fragments/header-home.html\';\r\n$headerSub = \'fragments/header-sub.html\';\r\n$footer = \'fragments/footer.html\';\r\n\r\n// Wybór strony\r\nif ($idp === \'\') {\r\n    $page = $baseDir . \'glowna.html\';\r\n    $header = $headerHome;\r\n} else {\r\n    $page = $baseDir . $idp . \'.html\';\r\n    $header = $headerSub;\r\n}\r\n\r\nif (!file_exists($page)) {\r\n    $page = $baseDir . \'error404.html\';\r\n    $header = $headerSub;\r\n}\r\n?>\r\n<!DOCTYPE html>\r\n<html lang=\"pl\">\r\n<head>\r\n    <meta charset=\"UTF-8\">\r\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\r\n\r\n    <title>Najpiękniejsze miejsca świata</title>\r\n\r\n    <!-- Style -->\r\n    <link rel=\"stylesheet\" href=\"assets/css/style.css\">\r\n\r\n    <!-- Skrypty globalne -->\r\n    <script src=\"assets/js/timedate.js\"></script>\r\n    <script src=\"assets/js/kolorujtlo.js\"></script>\r\n\r\n    <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js\"></script>\r\n</head>\r\n\r\n<body onload=\"startclock()\">\r\n\r\n<?php include($header); ?>\r\n\r\n<main>\r\n\r\n<?php if ($idp === \'\'): ?>\r\n\r\n    <section>\r\n      <h2>Witamy na stronie o najlepszych miejscach na świecie</h2>\r\n      <p>Odkryj najpiękniejsze miejsca jakie są na planecie ziemia, ale przez internet, bo nie masz budżetu by samemu tam polecieć.</p>\r\n    </section>\r\n\r\n    <section>\r\n      <h3>Na stronie:</h3>\r\n      <ul>\r\n        <li>Najpiękniejsze miejsca z każdego kontynentu na świecie</li>\r\n        <li>Galerie zdjęć z tych miejsc</li>\r\n        <li>Ciekawostki o danych miejscach</li>\r\n      </ul>\r\n    </section>\r\n\r\n<?php endif; ?>\r\n\r\n    <?php include($page); ?>\r\n\r\n</main>\r\n\r\n<?php include($footer); ?>\r\n\r\n</body>\r\n</html>\r\n', 1),
(9, 'style.css', 'body {\r\n  font-family: \"Segoe UI\", Arial, sans-serif;\r\n  margin: 0;\r\n  background-color: #faf2de;\r\n  color: #333;\r\n  line-height: 1.6;\r\n}\r\n\r\nheader {\r\n  background: url(\"../img/background.jpg\") center/cover no-repeat;\r\n  text-align: center;\r\n  color: white;\r\n  padding: 40px 20px;\r\n}\r\n\r\n.logo {\r\n  width: 80px;\r\n  border-radius: 50%;\r\n}\r\n\r\nnav ul {\r\n  list-style: none;\r\n  padding: 0;\r\n}\r\n\r\nnav ul li {\r\n  display: inline-block;\r\n  margin: 0 15px;\r\n}\r\n\r\nnav ul li a {\r\n  color: white;\r\n  text-decoration: none;\r\n  font-weight: bold;\r\n}\r\n\r\nnav ul li a:hover {\r\n  text-decoration: underline;\r\n}\r\n\r\nmain {\r\n  padding: 20px;\r\n  max-width: 1000px;\r\n  margin: auto;\r\n  background: transparent;\r\n  border-radius: 8px;\r\n  box-shadow: 0 0 10px rgba(0,0,0,0.1);\r\n}\r\n\r\n\r\n\r\n\r\nh1, h2, h3 {\r\n  color: #005b96;\r\n}\r\n\r\n.gallery {\r\n  display: grid;\r\n  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));\r\n  gap: 10px;\r\n}\r\n\r\n.gallery img {\r\n  width: 100%;\r\n  border-radius: 10px;\r\n}\r\n\r\ntable {\r\n  width: 100%;\r\n  border-collapse: collapse;\r\n  margin-top: 20px;\r\n}\r\n\r\nth, td {\r\n  border: 1px solid #aaa;\r\n  padding: 10px;\r\n  text-align: left;\r\n}\r\n\r\nth {\r\n  background-color: #e0f0ff;\r\n}\r\n\r\nfooter {\r\n  background-color: #003d73;\r\n  color: white;\r\n  text-align: center;\r\n  padding: 15px 0;\r\n  margin-top: 30px;\r\n}\r\n\r\n@media (max-width: 600px) {\r\n  nav ul li {\r\n    display: block;\r\n    margin: 10px 0;\r\n  }\r\n}\r\n/* --- Kolor tła: przyciski --- */\r\n.bg-change {\r\n    text-align: center;\r\n    margin: 20px 0;\r\n}\r\n\r\n.bg-change button {\r\n    padding: 8px 14px;\r\n    margin: 5px;\r\n    border: none;\r\n    cursor: pointer;\r\n    border-radius: 5px;\r\n    font-size: 14px;\r\n    transition: 0.3s ease;\r\n}\r\n\r\n.bg-change button:hover {\r\n    filter: brightness(1.2);\r\n}\r\n\r\n\r\n\r\nheader {\r\n    background-color: #004466;\r\n    color: white;\r\n    padding: 20px;\r\n    text-align: center;\r\n}\r\n\r\n.header-home h1,\r\n.header-sub h2 {\r\n    margin: 10px 0;\r\n}\r\n\r\n\r\nnav ul {\r\n    list-style: none;\r\n    padding: 0;\r\n    margin: 10px 0;\r\n    text-align: center;\r\n}\r\n\r\nnav ul li {\r\n    display: inline-block;\r\n    margin: 0 15px;\r\n}\r\n\r\nnav ul li a {\r\n    color: white;\r\n    text-decoration: none;\r\n    font-weight: bold;\r\n}\r\n\r\nnav ul li a:hover {\r\n    text-decoration: underline;\r\n}\r\n\r\n\r\n.clock-date-wrapper {\r\n    margin-top: 8px;\r\n    font-size: 13px;\r\n    font-weight: 500;\r\n}\r\n\r\n.test-block{\r\n  width: 200px;\r\n  border: 2px solid rgba(71,236,30,1);\r\n  background: rgba(71,236,30,0.7);\r\n  text-align: center;\r\n  color: #000;\r\n  padding: 20px;\r\n  cursor: pointer;\r\n  display: flex;\r\n  justify-content: center;\r\n  align-items: center;\r\n  -webkit-touch-callout: none;\r\n  -webkit-user-select: none;\r\n  -moz-user-select: none;\r\n  -ms-user-select: none;\r\n  user-select: none;\r\n}\r\n.bg-change button {\r\n  transition: transform 0.3s ease, box-shadow 0.3s ease;\r\n}\r\n\r\n.bg-change button:hover {\r\n  transform: scale(1.15);\r\n  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);\r\n}\r\n.video-container {\r\n  display: flex;\r\n  flex-wrap: wrap;\r\n  justify-content: center;\r\n  gap: 30px;\r\n  margin-top: 30px;\r\n}\r\n\r\n.video-box {\r\n  background-color: rgba(255, 255, 255, 0.1);\r\n  padding: 15px;\r\n  border-radius: 12px;\r\n  box-shadow: 0 2px 8px rgba(0,0,0,0.2);\r\n  text-align: center;\r\n  transition: transform 0.3s ease;\r\n}\r\n\r\n.video-box:hover {\r\n  transform: scale(1.05);\r\n}\r\n.shop-products {\r\n    display: grid;\r\n    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));\r\n    gap: 25px;\r\n    margin-top: 30px;\r\n}\r\n\r\n.product-card {\r\n    border: 1px solid #ddd;\r\n    border-radius: 12px;\r\n    padding: 20px;\r\n    background: #fff;\r\n    box-shadow: 0 4px 10px rgba(0,0,0,0.08);\r\n    transition: transform 0.2s ease, box-shadow 0.2s ease;\r\n}\r\n\r\n.product-card:hover {\r\n    transform: translateY(-5px);\r\n    box-shadow: 0 8px 20px rgba(0,0,0,0.15);\r\n}\r\n\r\n.product-card img {\r\n    width: 100%;\r\n    max-height: 180px;\r\n    object-fit: cover;\r\n    border-radius: 8px;\r\n    margin-bottom: 10px;\r\n}\r\n\r\n.product-card h3 {\r\n    margin-top: 0;\r\n    font-size: 20px;\r\n}\r\n\r\n.btn-cart {\r\n    display: inline-block;\r\n    margin-top: 10px;\r\n    padding: 8px 14px;\r\n    background: #2b7cff;\r\n    color: #fff;\r\n    text-decoration: none;\r\n    border-radius: 6px;\r\n}\r\n\r\n.btn-cart:hover {\r\n    background: #1a5ed8;\r\n}\r\n', 1),
(10, 'kolorujtlo.js', 'var computed = false;\r\nvar decimal = 0;\r\n\r\nfunction convert (entryform, from, to)\r\n{\r\n    convertfrom = from.selectedIndex;\r\n    convertto = to.selectedIndex;\r\n    entryform.display.value = (entryform.input.value * from[convertfrom].value / to[convertto].value);\r\n}\r\n\r\nfunction addChar (input, character)\r\n{\r\n    if((character==\'.\' && decimal==\"0\") || character!=\'.\')\r\n    {\r\n        (input.value == \"\" || input.value == \"0\") ? input.value = character : input.value += character\r\n        convert(input.form,input.form.measure1,input.form.measure2)\r\n        computed = true;\r\n        if (character==\'.\')\r\n        {\r\n            decimal = 1;\r\n        }\r\n    }\r\n}\r\n\r\nfunction openVothcom()\r\n{\r\n    window.open(\"\", \"Display window\",\"toolbar=no,directories=no,menubar=no\");\r\n}\r\n\r\nfunction clear (form)\r\n{\r\n    form.input.value = 0;\r\n    form.display.value = 0;\r\n    decimal=0;\r\n}\r\n\r\nfunction changeBackground(hexNumber)\r\n{\r\n    document.body.style.backgroundColor = hexNumber;\r\n}\r\n', 1),
(11, 'timedate.js', 'function gettheDate()\r\n{\r\n    Todays = new Date();\r\n    TheDate = \"\" + (Todays.getMonth() + 1) + \" / \" + Todays.getDate() + \" / \" + Todays.getFullYear();\r\n    document.getElementById(\"data\").innerHTML = TheDate;\r\n}\r\n\r\nvar timerID = null;\r\nvar timerRunning = false;\r\n\r\nfunction stopclock()\r\n{\r\n    if (timerRunning)\r\n        clearTimeout(timerID);\r\n    timerRunning = false;\r\n}\r\n\r\nfunction startclock()\r\n{\r\n    stopclock();\r\n    gettheDate();\r\n    showtime();\r\n}\r\n\r\nfunction showtime()\r\n{\r\n    var now = new Date();\r\n    var hours = now.getHours();\r\n    var minutes = now.getMinutes();\r\n    var seconds = now.getSeconds();\r\n    var timeValue = \"\" + ((hours > 12) ? hours - 12 : hours);\r\n    timeValue += ((minutes < 10) ? \":0\" : \":\") + minutes;\r\n    timeValue += ((seconds < 10) ? \":0\" : \":\") + seconds;\r\n    timeValue += (hours >= 12) ? \" P.M.\" : \" A.M.\";\r\n    document.getElementById(\"zegarek\").innerHTML = timeValue;\r\n    timerID = setTimeout(\"showtime()\", 1000);\r\n    timerRunning = true;\r\n}\r\n', 1),
(13, 'shop', 'SKLEP_DYNAMICZNY', 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  `price_netto` decimal(10,2) NOT NULL,
  `vat` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `category_id` int(11) NOT NULL,
  `size` varchar(50) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `description`, `created_at`, `updated_at`, `expires_at`, `price_netto`, `vat`, `stock`, `status`, `category_id`, `size`, `image`) VALUES
(1, 'City Break – Paryż', '3 dni w Paryżu, lot + hotel + przewodnik', '2026-01-17 14:19:03', NULL, NULL, 1800.00, 23, 12, 1, 1, 'średni', 'uploads/dell.jpg'),
(2, 'Wakacje w Grecji', '14 dni all inclusive na Krecie', '2026-01-17 14:19:03', NULL, NULL, 3200.00, 23, 8, 1, 2, 'mały', 'uploads/mysz.jpg'),
(3, 'Wycieczka 3-dniowa all inclusive – City Break (Praga)', '3 dni / 2 noce. Hotel + śniadania i obiadokolacje, zwiedzanie starego miasta, czas wolny.', '2026-01-22 03:06:31', NULL, '2027-12-31 00:00:00', 1199.00, 23, 20, 1, 1, 'mały', 'assets/img/shop/praga.jpg'),
(4, 'Wakacje 2 tygodnie all inclusive – Grecja (Kreta)', '14 dni. Resort all inclusive, plaża, wycieczka fakultatywna, transfer z lotniska.', '2026-01-22 03:06:31', NULL, '2027-12-31 00:00:00', 4999.00, 23, 12, 1, 2, 'duży', 'assets/img/shop/kreta.jpg'),
(5, 'Wakacje 2 tygodnie – Włochy (Sycylia)', '14 dni. Apartament, zwiedzanie okolicy, polecane trasy i miejsca.', '2026-01-22 03:06:31', NULL, '2027-12-31 00:00:00', 3599.00, 23, 10, 1, 3, 'duży', 'assets/img/shop/sycylia.jpg'),
(6, 'Wycieczka 3-dniowa – Kraków + Wieliczka', '3 dni. Nocleg, plan zwiedzania, kopalnia soli w Wieliczce.', '2026-01-22 03:06:31', NULL, '2027-12-31 00:00:00', 899.00, 23, 25, 1, 4, 'mały', 'assets/img/shop/krakow.jpg'),
(7, 'Wypad 1-dniowy – Termy (relaks)', '1 dzień. Wyjazd rano, kilka godzin w termach, powrót wieczorem.', '2026-01-22 03:06:31', NULL, '2027-12-31 00:00:00', 199.00, 23, 40, 1, 5, 'mały', 'assets/img/shop/termy.jpg'),
(8, 'Wypad 1-dniowy all inclusive – Park rozrywki', '1 dzień. Transport + bilety + posiłek na miejscu.', '2026-01-22 03:06:31', NULL, '2027-12-31 00:00:00', 299.00, 23, 30, 1, 6, 'mały', 'assets/img/shop/park.jpg'),
(9, 'Event czasowy – Zorza polarna (Norwegia)', 'Wyjazd sezonowy: polowanie na zorzę, noclegi, ciepły sprzęt, przewodnik.', '2026-01-22 03:06:31', NULL, '2027-03-31 00:00:00', 2799.00, 23, 8, 1, 7, 'średni', 'assets/img/shop/zorza.jpg'),
(10, 'Wycieczka 3-dniowa all inclusive – Wiedeń', '3 dni. Hotel, śniadania, zwiedzanie centrum i pałacu Schönbrunn.', '2026-01-22 03:06:31', NULL, '2027-12-31 00:00:00', 1299.00, 23, 18, 1, 1, 'mały', 'assets/img/shop/wieden.jpg'),
(11, 'Wakacje 2 tygodnie all inclusive – Hiszpania (Costa Brava)', '14 dni. All inclusive, blisko plaży, opcjonalne wycieczki.', '2026-01-22 03:06:31', NULL, '2027-12-31 00:00:00', 5399.00, 23, 9, 1, 2, 'duży', 'assets/img/shop/hiszpania.jpg'),
(12, 'Event czasowy – Jarmark świąteczny (Wrocław)', 'Wyjazd jednodniowy sezonowy: transport + czas wolny na jarmarku.', '2026-01-22 03:06:31', NULL, '2026-12-31 00:00:00', 149.00, 23, 60, 1, 7, 'mały', 'assets/img/shop/jarmark.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `page_list`
--
ALTER TABLE `page_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `page_list`
--
ALTER TABLE `page_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
