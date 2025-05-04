<?php
session_start();
include '../includes/db.php';

// Sprawdzamy, czy użytkownik jest zalogowany
if (!isset($_SESSION['id_user'])) {
    header('Location: login.php'); // Jeśli nie, przekierowujemy do strony logowania
    exit;
}

if (isset($_GET['id_rezerwacji'])) {
    $id_rezerwacji = $_GET['id_rezerwacji'];
    $id_user = $_SESSION['id_user'];

    // Sprawdzamy, czy rezerwacja należy do tego użytkownika
    $sql = "SELECT * FROM rezerwacje WHERE id_rezerwacji = :id_rezerwacji AND id_user = :id_user";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_rezerwacji', $id_rezerwacji, PDO::PARAM_INT);
    $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // Anulowanie rezerwacji
        $sql_update = "UPDATE rezerwacje SET status = 'Anulowana' WHERE id_rezerwacji = :id_rezerwacji";
        $stmt_update = $pdo->prepare($sql_update);
        $stmt_update->bindParam(':id_rezerwacji', $id_rezerwacji, PDO::PARAM_INT);
        $stmt_update->execute();

        header('Location: ../pages/moje_rezerwacje.php'); // Po anulowaniu przekierowujemy z powrotem
        exit;
    } else {
        echo "Nie znaleziono takiej rezerwacji.";
    }
} else {
    echo "Brak identyfikatora rezerwacji.";
}
?>
