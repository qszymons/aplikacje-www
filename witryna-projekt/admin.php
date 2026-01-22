<?php
/* =====================================================
   PANEL ADMINISTRACYJNY CMS
   Wersja projektu: v1.6+
   Plik: admin.php
   ===================================================== */

error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

/* -----------------------------------------------------
   Inicjalizacja sesji oraz konfiguracji bazy danych
   ----------------------------------------------------- */
session_start();
require_once __DIR__ . '/cfg.php';
require_once __DIR__ . '/kategorie.php';
require_once __DIR__ . '/produkty.php';

/* =====================================================
   UI helpers (małe pomocnicze funkcje do wyglądu)
   ===================================================== */
function AdminAlert($type, $text)
{
    $type = in_array($type, ['success', 'danger', 'info', 'warning'], true) ? $type : 'info';
    return '<div class="admin-alert admin-alert-'.$type.'">'.htmlspecialchars($text).'</div>';
}

/* =====================================================
   FORMULARZ LOGOWANIA DO PANELU CMS
   ===================================================== */
function FormularzLogowania()
{
    return '
    <div class="admin-card admin-login">
        <h1 class="admin-title">Panel CMS</h1>
        <p class="admin-subtitle">Zaloguj się, aby zarządzać treściami strony.</p>

        <form method="post" enctype="multipart/form-data"
              action="'.htmlspecialchars($_SERVER['REQUEST_URI']).'">

            <div class="admin-field">
                <label>Email</label>
                <input type="text" name="login_email" placeholder="admin" autocomplete="username">
            </div>

            <div class="admin-field">
                <label>Hasło</label>
                <input type="password" name="login_pass" placeholder="admin" autocomplete="current-password">
            </div>

            <button type="submit" name="x1_submit" class="admin-btn admin-btn-primary">
                Zaloguj
            </button>
        </form>
    </div>';
}

/* =====================================================
   DODAWANIE NOWEJ PODSTRONY
   ===================================================== */
function DodajNowaPodstrone()
{
    global $conn;

    if (isset($_POST['add_page'])) {

        $title   = mysqli_real_escape_string($conn, $_POST['page_title']);
        $content = mysqli_real_escape_string($conn, $_POST['page_content']);
        $status  = isset($_POST['status']) ? 1 : 0;

        $query = "
            INSERT INTO page_list (page_title, page_content, status)
            VALUES ('$title', '$content', '$status')
        ";
        mysqli_query($conn, $query);

        return '
            <div class="admin-card">
                '.AdminAlert('success', 'Nowa podstrona została dodana.').'
                <a class="admin-link" href="admin.php">← Wróć do listy</a>
            </div>
        ';
    }

    return '
    <div class="admin-card">
        <h2 class="admin-h2">Dodaj nową podstronę</h2>

        <form method="post" class="admin-form">
            <div class="admin-field">
                <label>Tytuł strony</label>
                <input type="text" name="page_title" required>
            </div>

            <div class="admin-field">
                <label>Treść strony</label>
                <textarea name="page_content" rows="12" required></textarea>
            </div>

            <label class="admin-check">
                <input type="checkbox" name="status" checked>
                Strona aktywna
            </label>

            <button type="submit" name="add_page" class="admin-btn admin-btn-primary">
                Dodaj podstronę
            </button>

            <a class="admin-btn admin-btn-ghost" href="admin.php">Anuluj</a>
        </form>
    </div>';
}

/* =====================================================
   LISTA PODSTRON
   ===================================================== */
function ListaPodstron()
{
    global $conn;

    $html = '
    <div class="admin-card">
        <div class="admin-card-header">
            <h2 class="admin-h2">Lista podstron</h2>
            <a class="admin-btn admin-btn-primary" href="admin.php?add=1">➕ Dodaj</a>
        </div>

        <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width:80px">ID</th>
                    <th>Tytuł</th>
                    <th style="width:180px">Akcje</th>
                </tr>
            </thead>
            <tbody>
    ';

    $query  = "SELECT id, page_title FROM page_list";
    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {

        $id    = (int)$row['id'];
        $title = htmlspecialchars($row['page_title']);

        $html .= "
            <tr>
                <td><span class=\"admin-pill\">$id</span></td>
                <td><b>$title</b></td>
                <td class=\"admin-actions\">
                    <a class=\"admin-btn admin-btn-small\" href=\"admin.php?edit=$id\">Edytuj</a>
                    <a class=\"admin-btn admin-btn-small admin-btn-danger\" href=\"admin.php?delete=$id\"
                       onclick=\"return confirm('Na pewno usunąć podstronę?');\">Usuń</a>
                </td>
            </tr>
        ";
    }

    $html .= '
            </tbody>
        </table>
        </div>
    </div>';

    return $html;
}

/* =====================================================
   USUWANIE PODSTRONY
   ===================================================== */
function UsunPodstrone($id)
{
    global $conn;

    $id = (int)$id;
    if ($id <= 0) {
        return '<div class="admin-card">'.AdminAlert('danger', 'Błędne ID podstrony.').'</div>';
    }

    $query = "DELETE FROM page_list WHERE id = $id LIMIT 1";
    mysqli_query($conn, $query);

    return '
        <div class="admin-card">
            '.AdminAlert('warning', 'Podstrona została usunięta.').'
            <a class="admin-link" href="admin.php">← Wróć do listy</a>
        </div>
    ';
}

/* =====================================================
   EDYCJA PODSTRONY
   ===================================================== */
function EdytujPodstrone($id)
{
    global $conn;

    $id = (int)$id;

    $query  = "SELECT * FROM page_list WHERE id = $id LIMIT 1";
    $result = mysqli_query($conn, $query);
    $row    = mysqli_fetch_assoc($result);

    if (!$row) {
        return '<div class="admin-card">'.AdminAlert('danger', 'Nie znaleziono podstrony.').'</div>';
    }

    if (isset($_POST['save_page'])) {

        $title   = mysqli_real_escape_string($conn, $_POST['page_title']);
        $content = mysqli_real_escape_string($conn, $_POST['page_content']);
        $status  = isset($_POST['status']) ? 1 : 0;

        $update = "
            UPDATE page_list
            SET page_title   = '$title',
                page_content = '$content',
                status       = '$status'
            WHERE id = $id
            LIMIT 1
        ";
        mysqli_query($conn, $update);

        return '
            <div class="admin-card">
                '.AdminAlert('success', 'Podstrona została zaktualizowana.').'
                <a class="admin-link" href="admin.php">← Wróć do listy</a>
            </div>
        ';
    }

    $checked = ((int)$row['status'] === 1) ? 'checked' : '';

    return '
    <div class="admin-card">
        <h2 class="admin-h2">Edycja podstrony</h2>

        <form method="post" class="admin-form">
            <div class="admin-field">
                <label>Tytuł strony</label>
                <input type="text" name="page_title" value="'.htmlspecialchars($row['page_title']).'" required>
            </div>

            <div class="admin-field">
                <label>Treść strony</label>
                <textarea name="page_content" rows="12" required>'.htmlspecialchars($row['page_content']).'</textarea>
            </div>

            <label class="admin-check">
                <input type="checkbox" name="status" '.$checked.'>
                Strona aktywna
            </label>

            <button type="submit" name="save_page" class="admin-btn admin-btn-primary">
                Zapisz zmiany
            </button>

            <a class="admin-btn admin-btn-ghost" href="admin.php">Anuluj</a>
        </form>
    </div>';
}

/* =====================================================
   LOGOWANIE I AUTORYZACJA
   ===================================================== */
$loginError = '';

if (isset($_POST['x1_submit'])) {
    if ($_POST['login_email'] === $login && $_POST['login_pass'] === $pass) {
        $_SESSION['zalogowany'] = true;
        header('Location: admin.php');
        exit;
    } else {
        $loginError = 'Błędne dane logowania.';
    }
}

/* =====================================================
   WYLOGOWANIE
   ===================================================== */
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: admin.php');
    exit;
}

/* =====================================================
   RENDER HTML
   ===================================================== */
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel CMS</title>

    <!-- Bierzemy styl Twojej strony -->
    <link rel="stylesheet" href="assets/css/style.css?v=<?= time() ?>">

    <style>
        /* =====================================================
           ADMIN THEME – spójny z Twoją stroną, ale "panelowy"
           ===================================================== */
        body { background: #f4f7fb; }
        header { background: none !important; padding: 0 !important; }
        main { background: transparent !important; box-shadow: none !important; }

        .admin-shell{
            max-width: 1100px;
            margin: 25px auto;
            padding: 0 15px;
        }

        .admin-topbar{
            background: #003d73;
            color: #fff;
            border-radius: 14px;
            padding: 16px 18px;
            display:flex;
            align-items:center;
            justify-content: space-between;
            gap: 12px;
            box-shadow: 0 10px 26px rgba(0,0,0,.12);
        }

        .admin-brand{
            display:flex;
            align-items:center;
            gap: 10px;
        }
        .admin-brand .badge{
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: rgba(255,255,255,.14);
            display:flex;
            align-items:center;
            justify-content:center;
            font-weight: 800;
        }
        .admin-brand h1{
            margin: 0;
            font-size: 18px;
            color: #fff;
        }
        .admin-brand p{
            margin: 0;
            opacity: .9;
            font-size: 13px;
        }

        .admin-nav{
            display:flex;
            flex-wrap:wrap;
            gap: 10px;
            justify-content:flex-end;
        }

        .admin-btn{
            display:inline-flex;
            align-items:center;
            gap: 8px;
            padding: 10px 12px;
            border-radius: 12px;
            text-decoration:none;
            border: 1px solid rgba(255,255,255,.22);
            color: #fff;
            background: rgba(255,255,255,.08);
            transition: .2s ease;
            font-weight: 700;
            font-size: 14px;
        }
        .admin-btn:hover{ transform: translateY(-1px); filter: brightness(1.05); }

        .admin-btn-primary{
            background: #2b7cff;
            border-color: rgba(255,255,255,.0);
            color: #fff;
        }
        .admin-btn-ghost{
            background: transparent;
            border-color: rgba(0,0,0,.12);
            color: #003d73;
        }
        .admin-btn-danger{
            background: #ffe9e9;
            border-color: rgba(0,0,0,.05);
            color: #9b0000;
        }
        .admin-btn-small{
            padding: 8px 10px;
            border-radius: 10px;
            font-size: 13px;
            color: #003d73;
            background: #e9f2ff;
            border: 1px solid rgba(0,0,0,.08);
        }
        .admin-btn-small:hover{ filter: brightness(0.98); }

        .admin-content{
            margin-top: 16px;
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 16px;
        }

        .admin-side{
            background: #ffffff;
            border-radius: 14px;
            padding: 14px;
            box-shadow: 0 10px 26px rgba(0,0,0,.08);
            height: fit-content;
        }
        .admin-side h3{
            margin: 0 0 10px;
            color: #003d73;
        }
        .admin-side a{
            display:block;
            text-decoration:none;
            padding: 10px 12px;
            border-radius: 12px;
            color: #003d73;
            font-weight: 700;
            margin-bottom: 8px;
            background: #f3f7ff;
            border: 1px solid rgba(0,0,0,.06);
        }
        .admin-side a:hover{
            filter: brightness(.98);
            transform: translateY(-1px);
            transition: .2s;
        }

        .admin-main{
            min-height: 300px;
        }

        .admin-card{
            background: #ffffff;
            border-radius: 14px;
            padding: 16px;
            box-shadow: 0 10px 26px rgba(0,0,0,.08);
            margin-bottom: 16px;
        }
        .admin-card-header{
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap: 10px;
            margin-bottom: 10px;
        }

        .admin-title{ margin: 0; color: #003d73; }
        .admin-subtitle{ margin: 6px 0 0; opacity: .85; }

        .admin-h2{
            margin: 0 0 10px;
            color: #003d73;
        }

        .admin-form{ margin-top: 10px; }
        .admin-field{ margin-bottom: 12px; }
        .admin-field label{
            display:block;
            font-weight: 700;
            margin-bottom: 6px;
            color: #003d73;
        }
        .admin-field input,
        .admin-field textarea{
            width: 100%;
            padding: 10px 12px;
            border-radius: 12px;
            border: 1px solid rgba(0,0,0,.15);
            outline: none;
        }
        .admin-field input:focus,
        .admin-field textarea:focus{
            border-color: #2b7cff;
            box-shadow: 0 0 0 4px rgba(43,124,255,.12);
        }

        .admin-check{
            display:flex;
            align-items:center;
            gap: 10px;
            font-weight: 700;
            color: #003d73;
            margin: 10px 0 14px;
        }

        .admin-link{
            color: #2b7cff;
            text-decoration:none;
            font-weight: 700;
        }
        .admin-link:hover{ text-decoration: underline; }

        .admin-pill{
            display:inline-block;
            padding: 4px 10px;
            border-radius: 999px;
            background: #e9f2ff;
            color: #003d73;
            font-weight: 800;
            font-size: 12px;
        }

        .admin-table-wrap{ overflow:auto; }
        .admin-table{
            width: 100%;
            border-collapse: collapse;
            background: #fff;
        }
        .admin-table th{
            text-align:left;
            background: #e9f2ff;
            color: #003d73;
            padding: 10px;
            border-bottom: 1px solid rgba(0,0,0,.08);
        }
        .admin-table td{
            padding: 10px;
            border-bottom: 1px solid rgba(0,0,0,.08);
        }
        .admin-actions{
            display:flex;
            gap: 8px;
            flex-wrap:wrap;
        }

        .admin-alert{
            border-radius: 12px;
            padding: 10px 12px;
            margin-bottom: 12px;
            font-weight: 700;
        }
        .admin-alert-success{ background:#e8fff1; color:#0b6b2a; }
        .admin-alert-danger{ background:#ffe9e9; color:#9b0000; }
        .admin-alert-warning{ background:#fff6d6; color:#7a5a00; }
        .admin-alert-info{ background:#e9f2ff; color:#003d73; }

        .admin-login{ max-width: 520px; margin: 60px auto; }
        .admin-login .admin-btn{ width: 100%; justify-content:center; }

        @media (max-width: 900px){
            .admin-content{ grid-template-columns: 1fr; }
        }
    </style>
</head>

<body>

<div class="admin-shell">

    <div class="admin-topbar">
        <div class="admin-brand">
            <div class="badge">CMS</div>
            <div>
                <h1>Panel administracyjny</h1>
                <p>Najpiękniejsze miejsca świata</p>
            </div>
        </div>

        <div class="admin-nav">
            <a class="admin-btn admin-btn-primary" href="admin.php">Dashboard</a>
            <a class="admin-btn" href="admin.php?logout=1">Wyloguj</a>
        </div>
    </div>

    <?php if (!isset($_SESSION['zalogowany'])): ?>
        <?php
            if (!empty($loginError)) {
                echo '<div class="admin-card">'.AdminAlert('danger', $loginError).'</div>';
            }
            echo FormularzLogowania();
            exit;
        ?>
    <?php endif; ?>

    <div class="admin-content">

        <aside class="admin-side">
            <h3>Menu</h3>
            <a href="admin.php">📄 Podstrony</a>
            <a href="admin.php?add=1">➕ Dodaj podstronę</a>
            <a href="admin.php?categories=1">🗂 Kategorie</a>
            <a href="admin.php?products=1">🧾 Produkty</a>
            <a href="index.php?idp=glowna">🏠 Strona główna</a>
        </aside>

        <section class="admin-main">
            <?php
            /* -----------------------------------------------------
               Routing metod administracyjnych
               ----------------------------------------------------- */
            if (isset($_GET['categories'])) {
                echo '<div class="admin-card"><h2 class="admin-h2">Kategorie</h2></div>';
                echo ZarzadzajKategoriami();
            }
            elseif (isset($_GET['products'])) {
                echo '<div class="admin-card"><h2 class="admin-h2">Produkty</h2></div>';
                echo ZarzadzajProduktami();
            }
            elseif (isset($_GET['add'])) {
                echo DodajNowaPodstrone();
            }
            elseif (isset($_GET['edit'])) {
                echo EdytujPodstrone($_GET['edit']);
            }
            elseif (isset($_GET['delete'])) {
                echo UsunPodstrone($_GET['delete']);
            }
            else {
                echo ListaPodstron();
            }
            ?>
        </section>

    </div>
</div>

</body>
</html>
