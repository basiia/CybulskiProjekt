<?php
session_start();
include '../includes/db.php';

$error = '';
$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $haslo = $_POST['haslo'];
    $rola = 'Klient';

    $stmt = $pdo->prepare("SELECT * FROM uzytkownicy WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $error = "Użytkownik o tym e-mailu już istnieje.";
    } else {
        $haslo_hash = password_hash($haslo, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO uzytkownicy (email, haslo, rola) VALUES (:email, :haslo, :rola)");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':haslo', $haslo_hash);
        $stmt->bindParam(':rola', $rola);

        if ($stmt->execute()) {
            $success = true;
        } else {
            $error = "Błąd podczas rejestracji.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Rejestracja - Karpol</title>
    <link rel="stylesheet" href="../styles/rejestracja-styled.css">
</head>
<body>
<div class="container">
    <div class="logo">Karpol</div>
    <h2>Zarejestruj się</h2>

    <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php elseif ($success): ?>
        <p class="success">Rejestracja zakończona sukcesem! <a href="login.php">Zaloguj się</a></p>
    <?php endif; ?>

    <form method="POST">
        <label for="email">Email</label>
        <input type="email" name="email" required>

        <label for="haslo">Hasło</label>
        <input type="password" name="haslo" required>

        <a class="forgot-password" href="#">Nie pamiętasz hasła?</a>

        <button type="submit">Utwórz konto</button>
    </form>

    <a class="register" href="login.php">Zaloguj się</a>
</div>
</body>
</html>
