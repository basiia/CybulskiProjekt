<?php
include '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_pojazdu = $_POST['id_pojazdu'];
    $id_user = $_POST['id_user'];
    $data_rezerwacji = date('Y-m-d');
    $zaliczka = $_POST['wielkosc_zaliczki'];

    // Domyślne wartości
    $status = 'Oczekująca';

    // Wyznaczenie daty ważności rezerwacji (np. 7 dni od daty rezerwacji)
    $data_waznosci = date('Y-m-d', strtotime($data_rezerwacji . ' +7 days'));

    try {
        // Sprawdzamy aktualny status pojazdu
        $sql_check = "SELECT status FROM Pojazdy WHERE id_pojazdu = :id_pojazdu FOR UPDATE";
        $stmt_check = $pdo->prepare($sql_check);
        $stmt_check->bindParam(':id_pojazdu', $id_pojazdu);
        $pdo->beginTransaction(); // blokujemy wiersz na czas sprawdzenia i dalszych operacji
        $stmt_check->execute();
        $pojazd = $stmt_check->fetch(PDO::FETCH_ASSOC);

        if (!$pojazd) {
            // Nie ma takiego pojazdu
            $pdo->rollBack();
            echo "<p>Pojazd o podanym ID nie istnieje.</p>";
            exit;
        }

        if ($pojazd['status'] === 'Zarezerwowany' || $pojazd['status'] === 'Sprzedany') {
            // Pojazd jest już zarezerwowany lub sprzedany
            $pdo->rollBack();
            echo "<p>Ten pojazd jest już niedostępny (status: " . htmlspecialchars($pojazd['status']) . ").</p>";
            echo "<a href='../pages/index.php'>Powrót do strony głównej</a>";
            exit;
        }

        // Jeśli status OK, to dodajemy rezerwację i zmieniamy status pojazdu
        $sql = "INSERT INTO rezerwacje (id_pojazdu, id_user, data_rezerwacji, status, wielkosc_zaliczki, data_waznosci)
                VALUES (:id_pojazdu, :id_user, :data_rezerwacji, :status, :zaliczka, :data_waznosci)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_pojazdu', $id_pojazdu);
        $stmt->bindParam(':id_user', $id_user);
        $stmt->bindParam(':data_rezerwacji', $data_rezerwacji);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':zaliczka', $zaliczka);
        $stmt->bindParam(':data_waznosci', $data_waznosci);
        $stmt->execute();

        $sql_update = "UPDATE Pojazdy SET status = 'Zarezerwowany' WHERE id_pojazdu = :id_pojazdu";
        $stmt_update = $pdo->prepare($sql_update);
        $stmt_update->bindParam(':id_pojazdu', $id_pojazdu);
        $stmt_update->execute();

        $pdo->commit();
        session_start();
        $_SESSION['popup'] = "Rezerwacja pojazdu została pomyślnie zarejestrowana!";

        header("Location: ../pages/szczegoly.php?id=" . urlencode($id_pojazdu));
        exit;

    } catch (PDOException $e) {
        $pdo->rollBack();
        echo "Błąd podczas zapisu rezerwacji: " . $e->getMessage();
    }
} else {
    echo "<p>Nieprawidłowe żądanie.</p>";
}
?>
