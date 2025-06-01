<?php include '../includes/header.php'; ?>
<?php
include '../includes/db.php';

if (!isset($_GET['id'])) {
    echo "<p>Brak ID pojazdu.</p>";
    include '../includes/footer.php';
    exit;
}

$id = $_GET['id'];

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

$sql = "SELECT data_przegladu, przebieg, wynik, uwagi 
        FROM historiaprzegladow 
        WHERE id_pojazdu = :id 
        ORDER BY data_przegladu DESC";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();
$przeglady = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<link rel="stylesheet" href="../styles/historia-przegladow-styled.css">

<div class="history-container">
    <h1>Historia przeglądów - <?= htmlspecialchars($vehicle['marka'] . " " . $vehicle['model']) ?></h1>

    <?php if ($przeglady): ?>
        <table class="history-table">
            <thead>
                <tr>
                    <th>Data przeglądu</th>
                    <th>Przebieg (km)</th>
                    <th>Wynik</th>
                    <th>Uwagi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($przeglady as $p): ?>
                <tr>
                    <td><?= date('d-m-Y', strtotime($p['data_przegladu'])) ?></td>
                    <td><?= number_format($p['przebieg'], 0, ',', ' ') ?></td>
                    <td><?= htmlspecialchars($p['wynik']) ?></td>
                    <td><?= nl2br(htmlspecialchars($p['uwagi'])) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Brak wpisów w historii przeglądów dla tego pojazdu.</p>
    <?php endif; ?>

    <a href="szczegoly.php?id=<?= $id ?>" class="btn-back">Wróć do szczegółów pojazdu</a>
</div>

<?php include '../includes/footer.php'; ?>
