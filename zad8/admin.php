<?php

session_start();
include('cfg.php');


function FormularzLogowania()
{
    $wynik = '
    <div class="logowanie">
        <h1 class="heading">Panel CMS :</h1>
        <form method="post" name="LoginForm" enctype="multipart/form-data" action="'.$_SERVER['REQUEST_URI'].'">
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
                    <td><input type="submit" name="x1_submit" value="Zaloguj" /></td>
                </tr>
            </table>
        </form>
    </div>';
    return $wynik;
}

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

        return '<p style="color:green"><b>Nowa podstrona została dodana.</b></p>
                <a href="admin.php">← wróć do listy</a>';
    }


    $form = '
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
    </form>
    ';

    return $form;
}


function ListaPodstron()
{
    global $conn;

    $wynik = '<h2>Lista podstron</h2>';
    $wynik .= '<table border="1" cellpadding="5">';
    $wynik .= '<tr>
                <th>ID</th>
                <th>Tytuł</th>
                <th>Akcje</th>
               </tr>';

    $query = "SELECT id, page_title FROM page_list";
    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $wynik .= '<tr>
            <td>'.$row['id'].'</td>
            <td>'.$row['page_title'].'</td>
            <td>
                <a href="admin.php?edit='.$row['id'].'">Edytuj</a> |
                <a href="admin.php?delete='.$row['id'].'">Usuń</a>
            </td>
        </tr>';
    }

    $wynik .= '</table>';
    return $wynik;
}

function UsunPodstrone($id)
{
    global $conn;

    $id = intval($id);

    if ($id <= 0) {
        return '<p>Błędne ID podstrony.</p>';
    }

    $query = "DELETE FROM page_list WHERE id = $id LIMIT 1";
    mysqli_query($conn, $query);

    return '<p style="color:red"><b>Podstrona została usunięta.</b></p>
            <a href="admin.php">← wróć do listy</a>';
}


function EdytujPodstrone($id)
{
    global $conn;

    $id = intval($id);


    $query = "SELECT * FROM page_list WHERE id = $id LIMIT 1";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    if (!$row) {
        return '<p>Nie znaleziono podstrony.</p>';
    }

    if (isset($_POST['save_page'])) {

        $title   = mysqli_real_escape_string($conn, $_POST['page_title']);
        $content = mysqli_real_escape_string($conn, $_POST['page_content']);
        $status  = isset($_POST['status']) ? 1 : 0;

        $update = "
            UPDATE page_list
            SET page_title='$title',
                page_content='$content',
                status='$status'
            WHERE id=$id
        ";

        mysqli_query($conn, $update);

        return '<p style="color:green"><b>Podstrona została zaktualizowana.</b></p>
                <a href="admin.php">← wróć do listy</a>';
    }

    $checked = ($row['status'] == 1) ? 'checked' : '';

    $form = '
    <h2>Edycja podstrony</h2>
    <form method="post">
        <label>Tytuł strony:</label><br>
        <input type="text" name="page_title" value="'.$row['page_title'].'" style="width:100%;"><br><br>

        <label>Treść strony:</label><br>
        <textarea name="page_content" rows="15" style="width:100%;">'.$row['page_content'].'</textarea><br><br>

        <label>
            <input type="checkbox" name="status" '.$checked.'> Strona aktywna
        </label><br><br>

        <input type="submit" name="save_page" value="Zapisz zmiany">
    </form>
    ';

    return $form;
}


if (isset($_POST['x1_submit'])) {
    if ($_POST['login_email'] == $login && $_POST['login_pass'] == $pass) {
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
echo '<h1>Panel administracyjny</h1>';
echo '<a href="admin.php?add=1">➕ Dodaj nową podstronę</a><br><br>';
echo '<a href="admin.php?logout=1">Wyloguj</a><br><br>';

if (isset($_GET['add'])) {
    echo DodajNowaPodstrone();
} elseif (isset($_GET['edit'])) {
    echo EdytujPodstrone($_GET['edit']);
} elseif (isset($_GET['delete'])) {
    echo UsunPodstrone($_GET['delete']);
} else {
    echo ListaPodstron();
}



if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: admin.php");
}
?>
