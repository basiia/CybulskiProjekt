<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['id_user']) || !in_array($_SESSION['rola'], ['Admin', 'Pracownik'])) {
    echo "Dostęp tylko dla pracowników lub administratorów.";
    exit;
}

echo "<h1>Panel administratora / pracownika</h1>";
echo "<p>Zalogowano jako: {$_SESSION['imie']} ({$_SESSION['rola']})</p>";
echo "<a href='logout.php'>Wyloguj</a><br><br>";

// Pobierz wszystkie rezerwacje
$sql = "SELECT r.*, p.marka, p.model, u.imie, u.nazwisko
        FROM rezerwacje r
        JOIN pojazdy p ON r.id_pojazdu = p.id_pojazdu
        JOIN uzytkownicy u ON r.id_user = u.id_user
        ORDER BY r.data_rezerwacji DESC";
$stmt = $pdo->query($sql);
$rezerwacje = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($rezerwacje) {
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>ID</th><th>Pojazd</th><th>Użytkownik</th><th>Data</th><th>Status</th><th>Zaliczka</th><th>Do</th></tr>";
    foreach ($rezerwacje as $r) {
        echo "<tr>";
        echo "<td>{$r['id_rezerwacji']}</td>";
        echo "<td>{$r['marka']} {$r['model']}</td>";
        echo "<td>{$r['imie']} {$r['nazwisko']}</td>";
        echo "<td>{$r['data_rezerwacji']}</td>";
        echo "<td>{$r['status']}</td>";
        echo "<td>{$r['wielkosc_zaliczki']} zł</td>";
        echo "<td>{$r['data_waznosci']}</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>Brak rezerwacji w systemie.</p>";
}
?>
