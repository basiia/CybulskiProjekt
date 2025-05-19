<?php
session_start();
include '../includes/db.php';
include '../includes/header.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Obsługa rejestracji
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $haslo = $_POST['haslo'];
    $imie = $_POST['imie'];
    $rola = 'Klient';

    $stmt = $pdo->prepare("SELECT * FROM uzytkownicy WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $blad = "Użytkownik o tym e-mailu już istnieje.";
    } else {
        $haslo_hash = password_hash($haslo, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO uzytkownicy (email, haslo, imie, rola) VALUES (:email, :haslo, :imie, :rola)");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':haslo', $haslo_hash);
        $stmt->bindParam(':imie', $imie);
        $stmt->bindParam(':rola', $rola);
        $stmt->execute();
        header("Location: login.php");
        exit;
    }
}
?>

<!-- Formularz rejestracji -->
<div style="max-width: 400px; margin: 100px auto; padding: 30px; background: white; border-radius: 12px;">
  <h2 style="text-align: center; font-size: 28px; margin-bottom: 30px;">Zarejestruj się</h2>

  <?php if (!empty($blad)) echo "<p style='color: red; text-align: center;'>$blad</p>"; ?>

  <form method="POST" style="display: flex; flex-direction: column; gap: 20px;">
    <input type="text" name="imie" placeholder="Imię" required style="padding: 14px; border-radius: 8px; border: 1px solid #ddd; background: #f9f9f9;">
    <input type="email" name="email" placeholder="Email" required style="padding: 14px; border-radius: 8px; border: 1px solid #ddd; background: #f9f9f9;">
    <input type="password" name="haslo" placeholder="Hasło" required style="padding: 14px; border-radius: 8px; border: 1px solid #ddd; background: #f9f9f9;">

    <a href="#" style="font-size: 14px; color: #003087; text-align: left;">Nie pamiętasz hasła?</a>

    <button type="submit" style="padding: 14px; background: #d80000; color: white; border: none; border-radius: 8px; font-weight: bold; font-size: 16px; cursor: pointer;">
      Utwórz konto
    </button>
  </form>

  <p style="text-align: center; margin-top: 20px;">
    <a href="login.php" style="color: #003087; font-weight: bold; text-decoration: none;">Zaloguj się</a>
  </p>
</div>


