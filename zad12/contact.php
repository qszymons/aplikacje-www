<?php
/* =====================================================
   PLIK: contact.php
   MODUŁ: Formularz kontaktowy i przypomnienie hasła
   -----------------------------------------------------
   Zawiera metody:
   1. PokazKontakt()
   2. WyslijMailKontakt()
   3. PrzypomnijHaslo()
   ===================================================== */


/* =====================================================
   FUNKCJA: PokazKontakt()
   -----------------------------------------------------
   Wyświetla formularz kontaktowy HTML.
   Formularz jest kompatybilny z metodą
   WyslijMailKontakt().
   ===================================================== */
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


/* =====================================================
   FUNKCJA: WyslijMailKontakt()
   -----------------------------------------------------
   Przetwarza dane z formularza PokazKontakt().
   Sprawdza kompletność danych oraz symuluje
   wysyłkę maila do administratora strony.
   ===================================================== */
function WyslijMailKontakt($odbiorca)
{
    // Jeżeli formularz nie został wysłany – nic nie rób
    if (!isset($_POST['send_mail'])) {
        return '';
    }

    /* -------------------------------------------------
       ZABEZPIECZENIE DANYCH $_POST
       ------------------------------------------------- */
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $temat = htmlspecialchars($_POST['temat'] ?? '');
    $tresc = htmlspecialchars($_POST['tresc'] ?? '');

    // Walidacja – sprawdzenie czy pola nie są puste
    if (empty($email) || empty($temat) || empty($tresc)) {
        return '[nie_wypelniles_pola]' . PokazKontakt();
    }

    /* -------------------------------------------------
       PRZYGOTOWANIE STRUKTURY WIADOMOŚCI
       ------------------------------------------------- */
    $mail['subject']   = $temat;
    $mail['body']      = $tresc;
    $mail['sender']    = $email;
    $mail['recipient'] = $odbiorca;

    /* -------------------------------------------------
       NAGŁÓWKI WIADOMOŚCI EMAIL
       ------------------------------------------------- */
    $header  = "From: Formularz kontaktowy <{$mail['sender']}>\n";
    $header .= "MIME-Version: 1.0\n";
    $header .= "Content-Type: text/plain; charset=utf-8\n";
    $header .= "Content-Transfer-Encoding: 8bit\n";
    $header .= "X-Mailer: PRapWWW mail 1.2\n";

    // mail() – pominięte, zgodnie z założeniem projektu (symulacja)

    return '<p style="color:green">[wiadomosc_wyslana]</p>';
}


/* =====================================================
   FUNKCJA: PrzypomnijHaslo()
   -----------------------------------------------------
   Uproszczona metoda przypominania hasła admina.
   Wysyła login i hasło w treści maila.
   UWAGA: Rozwiązanie NIEBEZPIECZNE – tylko edukacyjne!
   ===================================================== */
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

    // Formularz jeszcze nie wysłany
    if (!isset($_POST['remind_pass'])) {
        return $html;
    }

    // Zabezpieczenie danych wejściowych
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    if (empty($email)) {
        return '[nie_wypelniles_pola]' . $html;
    }

    /* -------------------------------------------------
       SYMULACJA WYSYŁKI MAILA Z HASŁEM
       ------------------------------------------------- */
    return '
    <p style="color:green">
        <b>Wiadomość została wysłana (symulacja).</b><br><br>
        Login admina: <b>'.$login.'</b><br>
        Hasło admina: <b>'.$pass.'</b><br><br>
        <small>
            <i>
            UWAGA: Jest to uproszczona i niebezpieczna forma
            przypominania hasła – tylko do celów edukacyjnych.
            </i>
        </small>
    </p>';
}


/* =====================================================
   LOGIKA WYŚWIETLANIA
   -----------------------------------------------------
   Jeżeli formularz został wysłany → przetwarzamy dane
   W przeciwnym razie → pokazujemy formularz
   ===================================================== */
if (isset($_POST['send_mail'])) {
    echo WyslijMailKontakt('admin@mojastrona.pl');
} else {
    echo PokazKontakt();
}
