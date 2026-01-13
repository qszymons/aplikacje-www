<?php
function PokazKontakt()
{
    return '
    <h2>Kontakt</h2>

    <form method="post" action="">
        <label>Twój email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Temat:</label><br>
        <input type="text" name="temat" required><br><br>

        <label>Wiadomość:</label><br>
        <textarea name="tresc" rows="5" required></textarea><br><br>

        <input type="submit" name="send_mail" value="Wyślij wiadomość">
    </form>
    ';
}

function WyslijMailKontakt($odbiorca)
{
    if (!isset($_POST['send_mail'])) {
        return '';
    }

    if (empty($_POST['temat']) || empty($_POST['tresc']) || empty($_POST['email'])) {
        return '[nie_wypelniles_pola]' . PokazKontakt();
    }

    $mail['subject']   = htmlspecialchars($_POST['temat']);
    $mail['body']      = htmlspecialchars($_POST['tresc']);
    $mail['sender']    = htmlspecialchars($_POST['email']);
    $mail['recipient'] = $odbiorca;

    $header  = "From: Formularz kontaktowy <".$mail['sender'].">\n";
    $header .= "MIME-Version: 1.0\n";
    $header .= "Content-Type: text/plain; charset=utf-8\n";
    $header .= "Content-Transfer-Encoding: 8bit\n";
    $header .= "X-Sender: <".$mail['sender'].">\n";
    $header .= "X-Mailer: PRapWWW mail 1.2\n";
    $header .= "X-Priority: 3\n";
    $header .= "Return-Path: <".$mail['sender'].">\n";

    return '<p style="color:green">[wiadomosc_wyslana]</p>';
}


function PrzypomnijHaslo()
{
    global $login, $pass;

    $html = '
    <h2>Przypomnij hasło</h2>

    <form method="post" action="">
        <label>Podaj email:</label><br>
        <input type="email" name="email" required><br><br>

        <input type="submit" name="remind_pass" value="Przypomnij hasło">
    </form>
    ';

    if (!isset($_POST['remind_pass'])) {
        return $html;
    }

    if (empty($_POST['email'])) {
        return '[nie_wypelniles_pola]' . $html;
    }

    $mail['subject'] = 'Przypomnienie hasła – panel admina';
    $mail['body']    = "Login: $login\nHasło: $pass";
    $mail['sender']  = 'admin@localhost';
    $mail['recipient'] = $_POST['email'];

    return '
    <p style="color:green">
        <b>Wiadomość została wysłana (symulacja).</b><br><br>
        Login admina: <b>'.$login.'</b><br>
        Hasło admina: <b>'.$pass.'</b><br><br>
        <small><i>UWAGA: Jest to uproszczona i niebezpieczna forma przypominania hasła.</i></small>
    </p>';
}



if (isset($_POST['send_mail'])) {
    echo WyslijMailKontakt('admin@mojastrona.pl');
} else {
    echo PokazKontakt();
}
