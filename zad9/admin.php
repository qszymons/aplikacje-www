<?php
/* =====================================================
   PANEL ADMINISTRACYJNY CMS
   Wersja projektu: v1.6
   Plik: admin.php
   ===================================================== */

/* -----------------------------------------------------
   Inicjalizacja sesji oraz konfiguracji bazy danych
   ----------------------------------------------------- */
session_start();
include('cfg.php');


/* =====================================================
   FORMULARZ LOGOWANIA DO PANELU CMS
   - wykorzystywany przy braku aktywnej sesji
   ===================================================== */
function FormularzLogowania()
{
    return '
    <div class="logowanie">
        <h1 class="heading">Panel CMS</h1>

        <form method="post" enctype="multipart/form-data"
              action="'.htmlspecialchars($_SERVER['REQUEST_URI']).'">

            <table class="logowanie">
                <tr>
                    <td>[email]</td>
                    <td><input type="text" name="login_email" /></td>
                </tr>

                <tr>
                    <td>[hasło]</td>
                    <td><input type="password" name="login_pass" /></td>
                </tr>

                <tr>
                    <td></td>
                    <td>
                        <input type="submit" name="x1_submit" value="Zaloguj" />
                    </td>
                </tr>
            </table>

        </form>
    </div>';
}


/* =====================================================
   DODAWANIE NOWEJ PODSTRONY
   - zapis do bazy danych (INSERT)
   ===================================================== */
function DodajNowaPodstrone()
{
    global $conn;

    if (isset($_POST['add_page'])) {

        // Zabezpieczenie danych formularza przed SQL Injection
        $title   = mysqli_real_escape_string($conn, $_POST['page_title']);
        $content = mysqli_real_escape_string($conn, $_POST['page_content']);
        $status  = isset($_POST['status']) ? 1 : 0;

        $query = "
            INSERT INTO page_list (page_title, page_content, status)
            VALUES ('$title', '$content', '$status')
        ";

        mysqli_query($conn, $query);

        return '
            <p style="color:green"><b>Nowa podstrona została dodana.</b></p>
            <a href="admin.php">← wróć do listy</a>
        ';
    }

    // Formularz dodawania nowej strony
    return '
    <h2>Dodaj nową podstronę</h2>

    <form method="post">
        <label>Tytuł strony:</label><br>
        <input type="text" name="page_title" style="width:100%;" required><br><br>

        <label>Treść strony:</label><br>
        <textarea name="page_content" rows="15" style="width:100%;" required></textarea><br><br>

        <label>
            <input type="checkbox" name="status" checked>
            Strona aktywna
        </label><br><br>

        <input type="submit" name="add_page" value="Dodaj podstronę">
    </form>';
}


/* =====================================================
   LISTA PODSTRON
   - wykorzystywana w panelu admina
   - zawiera linki: edycja / usuwanie
   ===================================================== */
function ListaPodstron()
{
    global $conn;

    $html = '
    <h2>Lista podstron</h2>
    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th>
            <th>Tytuł</th>
            <th>Akcje</th>
        </tr>';

    // LIMIT nie jest wymagany – lista wszystkich podstron
    $query  = "SELECT id, page_title FROM page_list";
    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {

        $id    = (int)$row['id'];
        $title = htmlspecialchars($row['page_title']);

        $html .= "
        <tr>
            <td>$id</td>
            <td>$title</td>
            <td>
                <a href=\"admin.php?edit=$id\">Edytuj</a> |
                <a href=\"admin.php?delete=$id\">Usuń</a>
            </td>
        </tr>";
    }

    $html .= '</table>';
    return $html;
}


/* =====================================================
   USUWANIE PODSTRONY
   - operacja DELETE po ID
   - zabezpieczenie LIMIT 1
   ===================================================== */
function UsunPodstrone($id)
{
    global $conn;

    $id = (int)$id;
    if ($id <= 0) {
        return '<p>Błędne ID podstrony.</p>';
    }

    $query = "DELETE FROM page_list WHERE id = $id LIMIT 1";
    mysqli_query($conn, $query);

    return '
        <p style="color:red"><b>Podstrona została usunięta.</b></p>
        <a href="admin.php">← wróć do listy</a>
    ';
}


/* =====================================================
   EDYCJA PODSTRONY
   - SELECT + UPDATE
   ===================================================== */
function EdytujPodstrone($id)
{
    global $conn;

    $id = (int)$id;

    // Pobranie danych edytowanej strony
    $query  = "SELECT * FROM page_list WHERE id = $id LIMIT 1";
    $result = mysqli_query($conn, $query);
    $row    = mysqli_fetch_assoc($result);

    if (!$row) {
        return '<p>Nie znaleziono podstrony.</p>';
    }

    // Zapis zmian
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
            <p style="color:green"><b>Podstrona została zaktualizowana.</b></p>
            <a href="admin.php">← wróć do listy</a>
        ';
    }

    $checked = ($row['status'] == 1) ? 'checked' : '';

    // Formularz edycji
    return '
    <h2>Edycja podstrony</h2>

    <form method="post">
        <label>Tytuł strony:</label><br>
        <input type="text" name="page_title" value="'.htmlspecialchars($row['page_title']).'" style="width:100%;"><br><br>

        <label>Treść strony:</label><br>
        <textarea name="page_content" rows="15" style="width:100%;">'.htmlspecialchars($row['page_content']).'</textarea><br><br>

        <label>
            <input type="checkbox" name="status" '.$checked.'>
            Strona aktywna
        </label><br><br>

        <input type="submit" name="save_page" value="Zapisz zmiany">
    </form>';
}


/* =====================================================
   LOGOWANIE I AUTORYZACJA
   ===================================================== */
if (isset($_POST['x1_submit'])) {

    if ($_POST['login_email'] === $login && $_POST['login_pass'] === $pass) {
        $_SESSION['zalogowany'] = true;
    } else {
        echo '<p style="color:red">Błędne dane logowania</p>';
        echo FormularzLogowania();
        exit;
    }
}

if (!isset($_SESSION['zalogowany'])) {
    echo FormularzLogowania();
    exit;
}


/* =====================================================
   WIDOK PANELU ADMINA
   ===================================================== */
echo '<h1>Panel administracyjny</h1>';
echo '<a href="admin.php?add=1">➕ Dodaj nową podstronę</a><br><br>';
echo '<a href="admin.php?logout=1">Wyloguj</a><br><br>';


/* -----------------------------------------------------
   Routing metod administracyjnych
   ----------------------------------------------------- */
if (isset($_GET['add'])) {
    echo DodajNowaPodstrone();
} elseif (isset($_GET['edit'])) {
    echo EdytujPodstrone($_GET['edit']);
} elseif (isset($_GET['delete'])) {
    echo UsunPodstrone($_GET['delete']);
} else {
    echo ListaPodstron();
}


/* =====================================================
   WYLOGOWANIE
   ===================================================== */
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: admin.php');
    exit;
}
?>
