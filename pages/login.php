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
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f6f6f6;
        }
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: white;
            max-width: 480px;
            margin: auto;
            padding: 40px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            align-self: flex-start;
            margin-bottom: 40px;
        }
        h2 {
            font-size: 32px;
            margin-bottom: 30px;
        }
        label {
            font-size: 16px;
            margin-top: 20px;
            margin-bottom: 5px;
            display: block;
            color: #555;
        }
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 14px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 16px;
            box-sizing: border-box;
        }
        .forgot-password {
            margin-top: 10px;
            font-size: 14px;
            color: #003087;
            text-decoration: none;
            display: block;
        }
        button {
            margin-top: 30px;
            width: 100%;
            padding: 14px;
            background-color: #d80000;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
        }
        .register {
            margin-top: 20px;
            font-size: 16px;
            color: #003087;
            text-align: center;
            text-decoration: none;
        }
        .error {
            color: red;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
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
</body>
</html>
