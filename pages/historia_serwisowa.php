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

// Pobierz pełną historię serwisową
$sql = "SELECT data_serwisu, opis, koszt, odpowiedzialny_serwis 
        FROM historiaserwisowa 
        WHERE id_pojazdu = :id 
        ORDER BY data_serwisu DESC";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();
$serwisy = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="history-container">
    <h1>Historia serwisowa - <?php echo htmlspecialchars($vehicle['marka'] . " " . $vehicle['model']); ?></h1>

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
                    <td><?php echo date('d-m-Y', strtotime($s['data_serwisu'])); ?></td>
                    <td><?php echo nl2br(htmlspecialchars($s['opis'])); ?></td>
                    <td><?php echo number_format($s['koszt'], 2, ',', '.'); ?></td>
                    <td><?php echo htmlspecialchars($s['odpowiedzialny_serwis']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Brak wpisów w historii serwisowej dla tego pojazdu.</p>
    <?php endif; ?>

    <p><a href="szczegoly.php?id=<?php echo $id; ?>" class="btn-back">Wróć do szczegółów pojazdu</a></p>
</div>

<?php include '../includes/footer.php'; ?>

<style>
.history-container {
    max-width: 900px;
    margin: 30px auto;
    padding: 20px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.15);
}
.history-container h1 {
    margin-bottom: 20px;
    font-size: 24px;
}
.history-table {
    width: 100%;
    border-collapse: collapse;
}
.history-table th,
.history-table td {
    border: 1px solid #ddd;
    padding: 10px 15px;
    text-align: left;
}
.history-table th {
    background-color: #007bff;
    color: white;
}
.history-table tr:nth-child(even) {
    background-color: #f8f9fa;
}
.btn-back {
    display: inline-block;
    margin-top: 20px;
    padding: 10px 16px;
    background-color: #6c757d;
    color: white;
    text-decoration: none;
    border-radius: 5px;
}
.btn-back:hover {
    background-color: #5a6268;
}
</style>
