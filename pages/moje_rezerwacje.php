<?php include '../includes/header.php'; ?>
<?php
include '../includes/db.php';

// Sprawdzamy, czy użytkownik jest zalogowany
if (!isset($_SESSION['id_user'])) {
    header('Location: login.php'); // Jeśli nie, przekierowujemy do strony logowania
    exit;
}

// Pobieramy dane użytkownika
$id_user = $_SESSION['id_user'];

// Zapytanie do bazy danych po rezerwacjach użytkownika
$sql = "SELECT r.id_rezerwacji, p.marka, p.model, p.rok_produkcji, r.data_rezerwacji, r.status, r.wielkosc_zaliczki, r.data_waznosci
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
            </tr>
        </thead>
        <tbody>
                <tr>
                    <td colspan="8">Brak rezerwacji.</td>
                </tr>
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
                                <form action="../functions/anuluj_rezerwacje.php" method="get">
                                    <input type="hidden" name="id_rezerwacji" value="<?php echo $rezerwacja['id_rezerwacji']; ?>">
                                    <button type="submit" class="btn-anuluj">Anuluj</button>
                                </form>
                            <?php elseif ($rezerwacja['status'] == 'Anulowana'): ?>
                                <span>Rezerwacja anulowana</span>
                            <?php endif; ?>
                        </td>

                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include '../includes/footer.php'; ?>

<!-- Stylizacja przycisku anulowania -->
<style>
    .btn-anuluj {
        background-color: #ff5733;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
    }

    .btn-anuluj:hover {
        background-color: #d84f2f;
    }
</style>
