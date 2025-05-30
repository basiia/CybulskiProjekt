<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['id_user'])) {
    header('Location: ../pages/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_rezerwacji'])) {
    $id_rezerwacji = $_POST['id_rezerwacji'];
    $id_user = $_SESSION['id_user'];

    // Sprawdź, czy rezerwacja należy do użytkownika i pobierz id pojazdu
    $stmt = $pdo->prepare("SELECT id_pojazdu FROM rezerwacje WHERE id_rezerwacji = :id_rezerwacji AND id_user = :id_user");
    $stmt->execute(['id_rezerwacji' => $id_rezerwacji, 'id_user' => $id_user]);
    $reservation = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$reservation) {
        $_SESSION['popup'] = "Nie znaleziono takiej rezerwacji lub nie masz do niej dostępu.";
        header('Location: ../pages/ustawienia.php?page=moje_rezerwacje');
        exit;
    }

    try {
        $pdo->beginTransaction();

        // Anuluj rezerwację
        $stmt_update = $pdo->prepare("UPDATE rezerwacje SET status = 'Anulowana' WHERE id_rezerwacji = :id_rezerwacji");
        $stmt_update->execute(['id_rezerwacji' => $id_rezerwacji]);

        // Ustaw pojazd jako dostępny
        $stmt_update_pojazd = $pdo->prepare("UPDATE pojazdy SET status = 'Dostępny' WHERE id_pojazdu = :id_pojazdu");
        $stmt_update_pojazd->execute(['id_pojazdu' => $reservation['id_pojazdu']]);

        $pdo->commit();

        $_SESSION['popup'] = "Rezerwacja została anulowana pomyślnie.";
        header('Location: ../pages/ustawienia.php?page=moje_rezerwacje');
        exit;

    } catch (PDOException $e) {
        $pdo->rollBack();
        $_SESSION['popup'] = "Błąd podczas anulowania rezerwacji: " . $e->getMessage();
        header('Location: ../pages/ustawienia.php?page=moje_rezerwacje');
        exit;
    }
} else {
    $_SESSION['popup'] = "Nieprawidłowe żądanie.";
    header('Location: ../pages/ustawienia.php?page=moje_rezerwacje');
    exit;
}
