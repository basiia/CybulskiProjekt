<?php
include '../includes/header.php';
include '../includes/db.php';


// Sprawdzamy, czy użytkownik jest zalogowany
if (!isset($_SESSION['id_user'])) {
    header('Location: login.php'); // Jeśli nie, przekierowujemy do strony logowania
    exit;
}

$id_user = $_SESSION['id_user'];

// Obsługa anulowania rezerwacji, jeśli jest w GET parametrze 'anuluj'
if (isset($_GET['anuluj'])) {
    $id_rezerwacji = (int)$_GET['anuluj'];

    // Sprawdzamy, czy rezerwacja należy do użytkownika i pobieramy id pojazdu
    $sql = "SELECT id_pojazdu, status FROM rezerwacje WHERE id_rezerwacji = :id_rezerwacji AND id_user = :id_user";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_rezerwacji', $id_rezerwacji, PDO::PARAM_INT);
    $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
    $stmt->execute();
    $rezerwacja = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($rezerwacja && ($rezerwacja['status'] == 'Zatwierdzona' || $rezerwacja['status'] == 'Oczekująca')) {
        // Ustawiamy status rezerwacji na "Anulowana"
        $sql = "UPDATE rezerwacje SET status = 'Anulowana' WHERE id_rezerwacji = :id_rezerwacji";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_rezerwacji', $id_rezerwacji, PDO::PARAM_INT);
        $stmt->execute();

        // Ustawiamy status pojazdu na "Dostępny"
        $sql = "UPDATE Pojazdy SET status = 'Dostępny' WHERE id_pojazdu = :id_pojazdu";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_pojazdu', $rezerwacja['id_pojazdu'], PDO::PARAM_INT);
        $stmt->execute();

        // Przekierowanie żeby odświeżyć stronę i uniknąć ponownego anulowania po odświeżeniu
        header('Location: ' . strtok($_SERVER["REQUEST_URI"], '?'));
        exit;
    }
}

// Pobieramy dane rezerwacji użytkownika
$sql = "SELECT r.id_rezerwacji, p.id_pojazdu, p.marka, p.model, p.rok_produkcji, r.data_rezerwacji, r.status, r.wielkosc_zaliczki, r.data_waznosci
        FROM rezerwacje r
        JOIN Pojazdy p ON r.id_pojazdu = p.id_pojazdu
        WHERE r.id_user = :id_user
        ORDER BY r.data_rezerwacji DESC";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
$stmt->execute();
$rezerwacje = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
<?php if (empty($rezerwacje)): ?>
    <h1>Brak rezerwacji.</h1>
<?php else: ?>
    <h1>Moje rezerwacje</h1>
    <table>
        <thead>
            <tr>
                <th>Marka</th>
                <th>Model</th>
                <th>Rok produkcji</th>
                <th>Data rezerwacji</th>
                <th>Status</th>
                <th>Wielkość zaliczki</th>
                <th>Data ważności</th>
                <th>Akcja</th>
                <th>Szczegóły</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rezerwacje as $rezerwacja): ?>
                <tr>
                    <td><?php echo htmlspecialchars($rezerwacja['marka']); ?></td>
                    <td><?php echo htmlspecialchars($rezerwacja['model']); ?></td>
                    <td><?php echo htmlspecialchars($rezerwacja['rok_produkcji']); ?></td>
                    <td><?php echo htmlspecialchars($rezerwacja['data_rezerwacji']); ?></td>
                    <td><?php echo htmlspecialchars($rezerwacja['status']); ?></td>
                    <td><?php echo number_format($rezerwacja['wielkosc_zaliczki'], 2, ',', '.'); ?> PLN</td>
                    <td><?php echo htmlspecialchars($rezerwacja['data_waznosci']); ?></td>
                    <td>
                        <?php if ($rezerwacja['status'] == 'Zatwierdzona' || $rezerwacja['status'] == 'Oczekująca'): ?>
                            <a href="?anuluj=<?php echo $rezerwacja['id_rezerwacji']; ?>" class="btn-anuluj" onclick="return confirm('Czy na pewno chcesz anulować tę rezerwację?');">Anuluj</a>
                        <?php elseif ($rezerwacja['status'] == 'Anulowana'): ?>
                            <span>Rezerwacja anulowana</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="szczegoly.php?id=<?php echo $rezerwacja['id_pojazdu']; ?>" class="btn-szczegoly">Zobacz auto</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>

<style>
    .btn-anuluj {
        background-color: #ff5733;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
        text-decoration: none;
        display: inline-block;
    }
    .btn-anuluj:hover {
        background-color: #d84f2f;
    }
    .btn-szczegoly {
        background-color: #007bff;
        color: white;
        padding: 8px 12px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: bold;
    }
    .btn-szczegoly:hover {
        background-color: #0056b3;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    th, td {
        padding: 12px 15px;
        border: 1px solid #ddd;
        text-align: center;
    }
    th {
        background-color: #f2f2f2;
    }
    .container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 20px;
    }
</style>
