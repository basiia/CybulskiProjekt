<?php
session_start();
include '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $haslo = $_POST['haslo'];

    $sql = "SELECT * FROM uzytkownicy WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($haslo, $user['haslo'])) {
        $_SESSION['id_user'] = $user['id_user'];
        $_SESSION['imie'] = $user['imie'];
        $_SESSION['rola'] = $user['rola'];
        $_SESSION['popup'] = 'Zalogowano pomyślnie.';
        header("Location: index.php");
        exit;
    } else {
        $error = "Błędny e-mail lub hasło.";
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Logowanie - Karpol</title>
    <link rel="stylesheet" href="../styles/login-styled.css">
</head>
<body>
    <div class="login-wrapper">
        <div class="login-box">
            <div class="logo">Karpol</div>
            <h2>Zaloguj się do konta</h2>

            <?php if (isset($error)): ?>
                <p class="error"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>

            <form method="POST">
                <label for="email">Email</label>
                <input type="email" name="email" required>

                <label for="haslo">Hasło</label>
                <input type="password" name="haslo" required>

                <a class="forgot-password" href="#">Nie pamiętasz hasła?</a>

                <button type="submit">Zaloguj się</button>
            </form>

            <a class="register" href="rejestracja.php">Zarejestruj się</a>
        </div>
    </div>
</body>
</html>
