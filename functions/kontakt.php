<?php
header('Content-Type: application/json');
include '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefon = trim($_POST['telefon'] ?? '');
    $wiadomosc = trim($_POST['wiadomosc'] ?? '');

    if (!$name || !$email || !$wiadomosc) {
        echo json_encode(['success' => false, 'message' => 'Wypełnij wszystkie wymagane pola.']);
        exit;
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO wiadomosci (name, email, telefon, wiadomosc) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $email, $telefon, $wiadomosc]);
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Błąd zapisu do bazy.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Nieprawidłowe żądanie.']);
}
