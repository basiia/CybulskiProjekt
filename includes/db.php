<?php
$host = 'localhost'; // lub adres serwera
$dbname = 'komis_samochodowy';
$username = 'root'; // Twoje dane logowania do bazy
$password = ''; // Hasło, jeśli jest wymagane

try {
    // Połączenie z bazą danych
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Ustawienie trybu błędów na wyjątki
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Błąd połączenia z bazą danych: ' . $e->getMessage();
    exit(); // Zatrzymujemy dalsze wykonywanie skryptu, jeśli połączenie nie powiodło się
}
?>
