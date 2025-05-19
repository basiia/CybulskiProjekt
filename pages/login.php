<?php
session_start();
include '../includes/db.php';
include '../includes/header.php';

// Obsługa logowania
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
        header("Location: index.php");
        exit;
    } else {
        $error = "Błędny e-mail lub hasło.";
    }
}
?>

<style>
body {
    margin: 0;
    font-family: Arial, sans-serif;
    background-color: #f6f6f6;
}

.container {
    max-width: 420px;
    margin: 100px auto 60px;
    background: white;
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 0 20px rgba(0,0,0,0.05);
}

h2 {
    font-size: 28px;
    text-align: center;
    margin-bottom: 30px;
}

input[type="email"],
input[type="password"] {
    width: 100%;
    padding: 14px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #f9f9f9;
    margin-bottom: 16px;
    box-sizing: border-box;
}

.forgot {
    font-size: 14px;
    color: #003087;
    text-decoration: none;
    display: block;
    margin-bottom: 20px;
}

button {
    width: 100%;
    padding: 14px;
    font-size: 16px;
    background: #d80000;
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: bold;
    cursor: pointer;
}

.register {
    margin-top: 20px;
    font-size: 16px;
    text-align: center;
}

.register a {
    color: #003087;
    text-decoration: none;
    font-weight: bold;
}

.error {
    color: red;
    text-align: center;
    margin-bottom: 16px;
}
</style>

<div class="container">
    <h2>Zaloguj się do konta</h2>

    <?php if (!empty($error)) echo "<div class='error'>$error</div>"; ?>

    <form method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="haslo" placeholder="Hasło" required>
        <a class="forgot" href="#">Nie pamiętasz hasła?</a>
        <button type="submit">Zaloguj się</button>
    </form>

    <div class="register">
        <a href="rejestracja.php">Zarejestruj się</a>
    </div>
</div>

