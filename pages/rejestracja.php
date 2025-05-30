<?php
session_start();
include '../includes/db.php';

// Wyświetlanie błędów
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $haslo = $_POST['haslo'];
    $imie = $_POST['imie'];
    $rola = 'Klient'; // domyślna rola, możesz zmienić

    // Sprawdź, czy email już istnieje
    $stmt = $pdo->prepare("SELECT * FROM uzytkownicy WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo "<p>Użytkownik o tym e-mailu już istnieje.</p>";
    } else {
        // Hashowanie hasła
        $haslo_hash = password_hash($haslo, PASSWORD_DEFAULT);

        // Wstawianie użytkownika
        $stmt = $pdo->prepare("INSERT INTO uzytkownicy (email, haslo, imie, rola) VALUES (:email, :haslo, :imie, :rola)");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':haslo', $haslo_hash);
        $stmt->bindParam(':imie', $imie);
        $stmt->bindParam(':rola', $rola);

        if ($stmt->execute()) {
            echo "<p>Rejestracja zakończona sukcesem. Możesz się <a href='login.php'>zalogować</a>.</p>";
        } else {
            echo "<p>Błąd podczas rejestracji.</p>";
        }
    }
} else {
    // Formularz rejestracji
    ?>
    <h2>Rejestracja</h2>
    <form method="POST">
        <label for="imie">Imię:</label><br>
        <input type="text" name="imie" required><br>
        <label for="email">Email:</label><br>
        <input type="email" name="email" required><br>
        <label for="haslo">Hasło:</label><br>
        <input type="password" name="haslo" required><br><br>
        <input type="submit" value="Zarejestruj się">
    </form>
    <?php
}
?>
