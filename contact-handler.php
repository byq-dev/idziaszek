<?php
// Sprawdzanie, czy formularz został wysłany metodą POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitizacja i walidacja danych
    $name = strip_tags(trim($_POST["name"]));
    $name = str_replace(array("\r","\n"),array(" "," "),$name);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = strip_tags(trim($_POST["subject"]));
    $message = trim($_POST["message"]);

    // Sprawdzenie, czy pola są wypełnione i czy e-mail jest prawidłowy
    if (empty($name) OR empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Ustawienie komunikatu o błędzie
        $errorMessage = "Proszę wypełnić wszystkie pola i podać prawidłowy adres e-mail.";
        include 'contact.html'; // lub inna ścieżka do Twojego pliku HTML
        exit;
    }

    // Adres e-mail, na który będą wysyłane wiadomości
    $recipient = "tutaj_wpisz_swoj_adres_email@example.com";

    // Budowanie nagłówków e-mail
    $headers = "Od: $name <$email>\r\n";
    $headers .= "Odpowiedz-do: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Budowanie treści e-maila
    $email_content = "Imię: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Wiadomość:\n$message\n";

    // Wysyłanie e-maila
    if (mail($recipient, $subject, $email_content, $headers)) {
        // Ustawienie komunikatu o sukcesie
        $successMessage = "Twoja wiadomość została wysłana! Dziękujemy";
    } else {
        // Ustawienie komunikatu o błędzie
        $errorMessage = "Oops! Coś poszło nie tak, nie można wysłać wiadomości.";
    }

    // Dołączenie strony HTML z komunikatem
    include 'contact.html'; // lub inna ścieżka do Twojego pliku HTML
} else {
    // Przekierowanie do formularza kontaktowego, jeśli strona nie została dostępna przez metodę POST
    header("Location: contact.html");
    exit;
}
?>