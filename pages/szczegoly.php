<?php 
include '../includes/header.php'; 
include '../includes/db.php';

function fetchHistory(PDO $pdo, string $table, string $dateColumn, int $vehicleId, int $limit = 3): array {
    $sql = "SELECT * FROM $table WHERE id_pojazdu = :id ORDER BY $dateColumn DESC LIMIT :limit";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $vehicleId, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function renderHistoryList(array $items, string $dateColumn, array $fieldsToShow, string $title, string $moreLink) {
    if (!$items) return;
    echo "<div class='vehicle-history'>";
    echo "<h3>$title</h3><ul>";
    foreach ($items as $item) {
        echo "<li><strong>" . date('d-m-Y', strtotime($item[$dateColumn])) . "</strong>";
        foreach ($fieldsToShow as $field => $label) {
            if (!empty($item[$field])) {
                $value = nl2br(htmlspecialchars($item[$field]));
                echo "<br><strong>$label:</strong> $value";
            }
        }
        echo "</li>";
    }
    echo "</ul>";
    echo "<a class='btn-see-more' href='$moreLink'>Zobacz więcej</a>";
    echo "</div>";
}

if (!isset($_GET['id'])) {
    echo "<p>Brak ID pojazdu w zapytaniu.</p>";
    include '../includes/footer.php';
    exit;
}

$id = (int)$_GET['id'];

$sql = "
    SELECT p.*, l.nazwa AS nazwa_lokacji, l.adres, l.miasto, l.kod_pocztowy 
    FROM Pojazdy p 
    JOIN lokacje l ON p.id_lokacji = l.id_lokacji 
    WHERE p.id_pojazdu = :id
";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$pojazd = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$pojazd) {
    echo "<p>Nie znaleziono pojazdu o takim ID.</p>";
    include '../includes/footer.php';
    exit;
}

$status_klasy = [
    'Zarezerwowany' => 'status-zarezerwowany',
    'Dostępny' => 'status-dostepny',
];
$status_klasa = $status_klasy[$pojazd['status']] ?? 'status-inny';

?>

<div class="vehicle-details">
    <h1 class="vehicle-title">
        <?= htmlspecialchars($pojazd['marka'] . ' ' . $pojazd['model']) ?>
        <span class="vehicle-status-badge <?= $status_klasa ?>">
            <?= htmlspecialchars($pojazd['status']) ?>
        </span>
    </h1>

    <div class="vehicle-summary">
        <div class="vehicle-image">
            <img src="../assets/car_place.png" alt="Zdjęcie pojazdu">
        </div>
        <div class="vehicle-info">
            <p><strong>Rok produkcji:</strong> <?= htmlspecialchars($pojazd['rok_produkcji']) ?></p>
            <p><strong>Przebieg:</strong> <?= number_format($pojazd['przebieg'], 0, ',', '.') ?> km</p>
            <p><strong>Cena:</strong> <?= number_format($pojazd['cena'], 2, ',', '.') ?> PLN</p>
            <p><strong>Rodzaj paliwa:</strong> <?= htmlspecialchars($pojazd['rodzaj_paliwa']) ?></p>
            <p><strong>Typ pojazdu:</strong> <?= htmlspecialchars($pojazd['typ_pojazdu']) ?></p>
            <p><strong>Oddział:</strong> <?= htmlspecialchars($pojazd['nazwa_lokacji']) ?></p>
        </div>
    </div>

    <div class="vehicle-specs">
        <h3>Szczegóły pojazdu</h3>
        <p><strong>Kolor:</strong> <?= htmlspecialchars($pojazd['kolor']) ?></p>
        <p><strong>Rodzaj nadwozia:</strong> <?= htmlspecialchars($pojazd['rodzaj_nadwozia']) ?></p>
        <p><strong>Pojemność silnika:</strong> <?= htmlspecialchars($pojazd['pojemnosc_silnika']) ?> L</p>
        <p><strong>Moc:</strong> <?= htmlspecialchars($pojazd['moc_kw']) ?> kW</p>
        <p><strong>VIN:</strong> <?= htmlspecialchars($pojazd['vin']) ?></p>
        <p><strong>Skrzynia biegów:</strong> <?= htmlspecialchars($pojazd['skrzynia_biegow']) ?></p>
        <p><strong>Napęd:</strong> <?= htmlspecialchars($pojazd['naped']) ?></p>
        <p><strong>Kierownica:</strong> <?= $pojazd['kierownica_prawa'] ? 'Prawa' : 'Lewa' ?></p>
        <p><strong>Liczba drzwi:</strong> <?= htmlspecialchars($pojazd['liczba_drzwi']) ?></p>
        <p><strong>Liczba miejsc:</strong> <?= htmlspecialchars($pojazd['liczba_miejsc']) ?></p>
        <p><strong>Kraj pochodzenia:</strong> <?= htmlspecialchars($pojazd['kraj_pochodzenia']) ?></p>
        <p><strong>Data pierwszej rejestracji:</strong> <?= date('d-m-Y', strtotime($pojazd['data_pierwszej_rejestracji'])) ?></p>
        <p><strong>Numer rejestracyjny:</strong> <?= htmlspecialchars($pojazd['numer_rejestracyjny']) ?></p>
        <p><strong>Stan techniczny:</strong> <?= htmlspecialchars($pojazd['stan_techniczny']) ?></p>
    </div>

    <?php if ($pojazd['wyposazenie_dodatkowe']): ?>
        <div class="vehicle-extra-equipment">
            <h3>Wyposażenie dodatkowe</h3>
            <p><?= nl2br(htmlspecialchars($pojazd['wyposazenie_dodatkowe'])) ?></p>
        </div>
    <?php endif; ?>

    <?php
    $przeglady = fetchHistory($pdo, 'historiaprzegladow', 'data_przegladu', $pojazd['id_pojazdu']);
    renderHistoryList($przeglady, 'data_przegladu', [
        'przebieg' => 'Przebieg',
        'wynik' => 'Wynik',
        'uwagi' => 'Uwagi'
    ], 'Historia przeglądów', 'historia_przegladow.php?id=' . $pojazd['id_pojazdu']);

    $serwisy = fetchHistory($pdo, 'historiaserwisowa', 'data_serwisu', $pojazd['id_pojazdu']);
    renderHistoryList($serwisy, 'data_serwisu', [
        'koszt' => 'Koszt',
        'opis' => 'Opis',
        'odpowiedzialny_serwis' => 'Odpowiedzialny serwis'
    ], 'Historia serwisowa', 'historia_serwisowa.php?id=' . $pojazd['id_pojazdu']);
    ?>

    <?php if ($pojazd['status'] !== 'Zarezerwowany'): ?>
        <a class="btn-reserve" href="rezerwacja.php?id=<?= $pojazd['id_pojazdu'] ?>">Zarezerwuj pojazd</a>
    <?php else: ?>
        <p style="color:#dc3545; font-weight:bold; margin-top:20px;">Pojazd jest aktualnie zarezerwowany.</p>
    <?php endif; ?>

</div>

<?php
// Podobne pojazdy
$sql_similar = "
    SELECT * FROM Pojazdy 
    WHERE typ_pojazdu = :typ_pojazdu 
    AND liczba_drzwi = :liczba_drzwi 
    AND ABS(rok_produkcji - :rok_produkcji) <= 2 
    AND id_pojazdu != :id 
    LIMIT 3
";
$stmt_similar = $pdo->prepare($sql_similar);
$stmt_similar->bindParam(':typ_pojazdu', $pojazd['typ_pojazdu']);
$stmt_similar->bindParam(':liczba_drzwi', $pojazd['liczba_drzwi']);
$stmt_similar->bindParam(':rok_produkcji', $pojazd['rok_produkcji']);
$stmt_similar->bindParam(':id', $pojazd['id_pojazdu']);
$stmt_similar->execute();
$similar_vehicles = $stmt_similar->fetchAll(PDO::FETCH_ASSOC);

if ($similar_vehicles):
?>
<div class="similar-vehicles">
    <h2>Podobne pojazdy</h2>
    <div class="vehicle-list">
        <?php foreach ($similar_vehicles as $similar): ?>
        <div class="vehicle-item">
            <img src="../assets/car_place.png" alt="Zdjęcie pojazdu" class="vehicle-thumbnail">
            <h3><?= htmlspecialchars($similar['marka'] . ' ' . $similar['model']) ?></h3>
            <p>Rok produkcji: <?= htmlspecialchars($similar['rok_produkcji']) ?></p>
            <p>Przebieg: <?= number_format($similar['przebieg'], 0, ',', '.') ?> km</p>
            <p class="price"><?= number_format($similar['cena'], 2, ',', '.') ?> PLN</p>
            <a class="details-link" href="szczegoly.php?id=<?= $similar['id_pojazdu'] ?>">Zobacz szczegóły</a>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php
endif;
include '../includes/footer.php';
?>

<style>
.vehicle-details {
    max-width: 1200px;
    margin: 20px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}
.vehicle-summary {
    display: flex;
    gap: 30px;
    margin-top: 20px;
}
.vehicle-image img {
    max-width: 300px;
    border-radius: 8px;
    border: 1px solid #ccc;
}
.vehicle-info p {
    font-size: 1.1rem;
    margin-bottom: 8px;
}
.vehicle-title {
    font-size: 2.4rem;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 15px;
}
.vehicle-status-badge {
    padding: 6px 14px;
    font-weight: 700;
    border-radius: 14px;
    color: #fff;
    font-size: 1.1rem;
    text-transform: uppercase;
}
.status-zarezerwowany {
    background-color: #dc3545; /* czerwony */
}
.status-dostepny {
    background-color: #28a745; /* zielony */
}
.status-inny {
    background-color: #6c757d; /* szary */
}
.vehicle-specs {
    margin-top: 30px;
    font-size: 1.1rem;
}
.vehicle-extra-equipment {
    margin-top: 20px;
    background: #f9f9f9;
    padding: 15px;
    border-radius: 6px;
    font-size: 1.1rem;
}
.vehicle-history {
    margin-top: 40px;
    padding: 20px;
    background-color: #eef2f7;
    border-radius: 6px;
}
.vehicle-history h3 {
    margin-bottom: 15px;
}
.vehicle-history ul {
    list-style-type: none;
    padding-left: 0;
}
.vehicle-history li {
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 1px solid #ccc;
    font-size: 1.1rem;
}
.btn-see-more {
    display: inline-block;
    margin-top: 10px;
    padding: 8px 18px;
    background-color: #007bff;
    color: #fff;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 600;
}
.btn-see-more:hover {
    background-color: #0056b3;
}
.btn-reserve {
    display: inline-block;
    margin-top: 40px;
    padding: 14px 28px;
    background-color: #28a745;
    color: #fff;
    border-radius: 8px;
    font-size: 1.3rem;
    font-weight: 700;
    text-decoration: none;
}
.btn-reserve:hover {
    background-color: #1e7e34;
}
.similar-vehicles {
    margin-top: 50px;
}
.similar-vehicles h2 {
    font-size: 2rem;
    margin-bottom: 20px;
}
.vehicle-list {
    display: flex;
    gap: 25px;
    flex-wrap: wrap;
}
.vehicle-item {
    background: #fefefe;
    border-radius: 8px;
    padding: 15px;
    width: 280px;
    box-shadow: 0 3px 8px rgba(0,0,0,0.1);
    text-align: center;
}
.vehicle-item img.vehicle-thumbnail {
    max-width: 100%;
    border-radius: 8px;
    margin-bottom: 10px;
}
.vehicle-item h3 {
    margin-bottom: 8px;
    font-size: 1.3rem;
}
.price {
    color: #007bff;
    font-weight: 700;
    margin-bottom: 12px;
}
.details-link {
    display: inline-block;
    padding: 6px 12px;
    background-color: #17a2b8;
    color: #fff;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 600;
}
.details-link:hover {
    background-color: #117a8b;
}
</style>
