<?php include '../includes/header.php'; ?>
<?php
include '../includes/db.php';

if (!isset($_GET['id'])) {
    echo "<p>Brak ID pojazdu.</p>";
    include '../includes/footer.php';
    exit;
}

$id = $_GET['id'];

// Pobierz dane pojazdu
$sql_veh = "SELECT marka, model FROM Pojazdy WHERE id_pojazdu = :id";
$stmt_veh = $pdo->prepare($sql_veh);
$stmt_veh->bindParam(':id', $id);
$stmt_veh->execute();
$vehicle = $stmt_veh->fetch(PDO::FETCH_ASSOC);

if (!$vehicle) {
    echo "<p>Nie znaleziono pojazdu o podanym ID.</p>";
    include '../includes/footer.php';
    exit;
}

// Pobierz historię serwisową
$sql = "SELECT data_serwisu, opis, koszt, odpowiedzialny_serwis 
        FROM historiaserwisowa 
        WHERE id_pojazdu = :id 
        ORDER BY data_serwisu DESC";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();
$serwisy = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<link rel="stylesheet" href="../styles/historia-serwisowa-styled.css">

<div class="history-container">
    <h1>Historia serwisowa – <?= htmlspecialchars($vehicle['marka'] . ' ' . $vehicle['model']) ?></h1>

    <?php if ($serwisy): ?>
        <table class="history-table">
            <thead>
                <tr>
                    <th>Data serwisu</th>
                    <th>Opis</th>
                    <th>Koszt (PLN)</th>
                    <th>Odpowiedzialny serwis</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($serwisy as $s): ?>
                <tr>
                    <td><?= date('d-m-Y', strtotime($s['data_serwisu'])) ?></td>
                    <td><?= nl2br(htmlspecialchars($s['opis'])) ?></td>
                    <td><?= number_format($s['koszt'], 2, ',', ' ') ?></td>
                    <td><?= htmlspecialchars($s['odpowiedzialny_serwis']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Brak wpisów w historii serwisowej dla tego pojazdu.</p>
    <?php endif; ?>

    <a href="szczegoly.php?id=<?= $id ?>" class="btn-back">Wróć do szczegółów pojazdu</a>
</div>

<?php include '../includes/footer.php'; ?>
