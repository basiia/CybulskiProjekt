<?php
include '../includes/header.php';
include '../includes/db.php';

function fetchHistory(PDO $pdo, string $table, string $dateColumn, int $vehicleId, int $limit = 3): array {
    $stmt = $pdo->prepare("SELECT * FROM $table WHERE id_pojazdu = :id ORDER BY $dateColumn DESC LIMIT :limit");
    $stmt->bindParam(':id', $vehicleId, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function renderHistoryList(array $items, string $dateColumn, array $fields, string $title, string $moreLink) {
    if (!$items) return;
    echo "<div class='vehicle-history'><h3>$title</h3><ul>";
    foreach ($items as $item) {
        echo "<li><strong>" . date('d.m.Y', strtotime($item[$dateColumn])) . "</strong>";
        foreach ($fields as $field => $label) {
            if (!empty($item[$field])) {
                echo "<br><strong>$label:</strong> " . nl2br(htmlspecialchars($item[$field]));
            }
        }
        echo "</li>";
    }
    echo "</ul><a class='btn-see-more' href='$moreLink'>Zobacz więcej</a></div>";
}

if (!isset($_GET['id'])) {
    echo "<p>Brak ID pojazdu w zapytaniu.</p>";
    include '../includes/footer.php';
    exit;
}

$id = (int)$_GET['id'];
$stmt = $pdo->prepare("
    SELECT p.*, l.nazwa AS nazwa_lokacji
    FROM Pojazdy p
    LEFT JOIN lokacje l ON p.id_lokacji = l.id_lokacji
    WHERE p.id_pojazdu = :id
");
$stmt->execute([':id' => $id]);
$pojazd = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$pojazd) {
    echo "<p>Nie znaleziono pojazdu.</p>";
    include '../includes/footer.php';
    exit;
}

$status_klasy = [
    'Zarezerwowany' => 'status-zarezerwowany',
    'Dostępny' => 'status-dostepny',
];
$status_klasa = $status_klasy[$pojazd['status']] ?? 'status-inny';
?>

<link rel="stylesheet" href="../styles/szczegoly-styled.css">

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
            <p><strong>Rok produkcji:</strong> <?= $pojazd['rok_produkcji'] ?></p>
            <p><strong>Przebieg:</strong> <?= number_format($pojazd['przebieg'], 0, ',', ' ') ?> km</p>
            <p><strong>Cena:</strong> <?= number_format($pojazd['cena'], 2, ',', ' ') ?> PLN</p>
            <p><strong>Rodzaj paliwa:</strong> <?= $pojazd['rodzaj_paliwa'] ?></p>
            <p><strong>Typ pojazdu:</strong> <?= $pojazd['typ_pojazdu'] ?></p>
            <p><strong>Oddział:</strong> <?= $pojazd['nazwa_lokacji'] ?></p>
        </div>
    </div>

    <div class="vehicle-specs">
        <h3>Szczegóły pojazdu</h3>
        <p><strong>Kolor:</strong> <?= $pojazd['kolor'] ?></p>
        <p><strong>Rodzaj nadwozia:</strong> <?= $pojazd['rodzaj_nadwozia'] ?></p>
        <p><strong>Pojemność silnika:</strong> <?= $pojazd['pojemnosc_silnika'] ?> L</p>
        <p><strong>Moc:</strong> <?= $pojazd['moc_kw'] ?> kW</p>
        <p><strong>VIN:</strong> <?= $pojazd['vin'] ?></p>
        <p><strong>Skrzynia biegów:</strong> <?= $pojazd['skrzynia_biegow'] ?></p>
        <p><strong>Napęd:</strong> <?= $pojazd['naped'] ?></p>
        <p><strong>Kierownica:</strong> <?= $pojazd['kierownica_prawa'] ? 'Prawa' : 'Lewa' ?></p>
        <p><strong>Liczba drzwi:</strong> <?= $pojazd['liczba_drzwi'] ?></p>
        <p><strong>Liczba miejsc:</strong> <?= $pojazd['liczba_miejsc'] ?></p>
        <p><strong>Kraj pochodzenia:</strong> <?= $pojazd['kraj_pochodzenia'] ?></p>
        <p><strong>Data pierwszej rejestracji:</strong> <?= date('d.m.Y', strtotime($pojazd['data_pierwszej_rejestracji'])) ?></p>
        <p><strong>Numer rejestracyjny:</strong> <?= $pojazd['numer_rejestracyjny'] ?></p>
        <p><strong>Stan techniczny:</strong> <?= nl2br(htmlspecialchars($pojazd['stan_techniczny'])) ?></p>
    </div>

    <?php if (!empty($pojazd['wyposazenie_dodatkowe'])): ?>
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
        <p class="vehicle-unavailable">Pojazd jest aktualnie zarezerwowany.</p>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>
