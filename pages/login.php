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

        echo "<p>Zalogowano jako {$user['imie']} ({$user['rola']})</p>";
        echo "<a href='./index.php'>Przejdź do strony głównej</a>";
    } else {
        echo "<p>Błędny e-mail lub hasło.</p>";
    }
} else {
    // Formularz logowania
    ?>
    <h2>Logowanie</h2>
    <form method="POST">
        <label for="email">Email:</label><br>
        <input type="email" name="email" required><br>
        <label for="haslo">Hasło:</label><br>
        <input type="password" name="haslo" required><br><br>
        <input type="submit" value="Zaloguj się">
    </form>
    <?php
}
?>
