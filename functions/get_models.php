<?php
include '../includes/db.php';

if (isset($_GET['marka'])) {
    $marka = $_GET['marka'];
    $stmt = $pdo->prepare("SELECT DISTINCT model FROM Pojazdy WHERE marka = :marka");
    $stmt->execute(['marka' => $marka]);
    $models = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo json_encode($models);
} else {
    echo json_encode([]);
}
