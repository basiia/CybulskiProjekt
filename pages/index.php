<?php
include '../includes/db.php';
include '../includes/header.php';

// Pobieranie danych do formularza
$stmt_marki     = $pdo->query("SELECT DISTINCT marka FROM Pojazdy");
$stmt_paliwa    = $pdo->query("SELECT DISTINCT rodzaj_paliwa FROM Pojazdy");
$stmt_rocznik   = $pdo->query("SELECT DISTINCT rok_produkcji FROM Pojazdy ORDER BY rok_produkcji DESC");
$stmt_locations = $pdo->query("SELECT id_lokacji, miasto FROM Lokacje");

// Polecane pojazdy z filtrem lokalizacji (jeśli podana)
if (isset($id_lokacji)) {
    $stmt_recommended = $pdo->prepare("SELECT * FROM Pojazdy WHERE status = 'Dostępny' AND id_lokacji = :id_lokacji ORDER BY RAND() LIMIT 3");
    $stmt_recommended->bindParam(':id_lokacji', $id_lokacji, PDO::PARAM_INT);
    $stmt_recommended->execute();
} else {
    $stmt_recommended = $pdo->query("SELECT * FROM Pojazdy WHERE status = 'Dostępny' ORDER BY RAND() LIMIT 3");
}


// Sprawdzenie, czy jest przekazana lokalizacja przez GET (z linków)
$selected_location = null;
if (isset($_GET['id_lokacji'])) {
    $id_lokacji = (int)$_GET['id_lokacji'];
    $stmt_loc = $pdo->prepare("SELECT miasto FROM Lokacje WHERE id_lokacji = ?");
    $stmt_loc->execute([$id_lokacji]);
    $selected_location = $stmt_loc->fetchColumn();
}
?>

<?php if ($selected_location): ?>
    <p>Jesteś w lokalizacji: <strong><?= htmlspecialchars($selected_location) ?></strong></p>
<?php endif; ?>

<h1>Znajdź swój idealny samochód</h1>

<form class="search-bar" method="GET" action="search.php">
    <select name="marka" id="marka">
        <option value="">Marka</option>
        <?php while ($row = $stmt_marki->fetch()): ?>
            <option value="<?= htmlspecialchars($row['marka']) ?>"><?= htmlspecialchars($row['marka']) ?></option>
        <?php endwhile; ?>
    </select>

    <select name="model" id="model" disabled>
        <option value="">Model</option>
    </select>

    <select name="paliwo">
        <option value="">Paliwo</option>
        <?php while ($row = $stmt_paliwa->fetch()): ?>
            <option value="<?= htmlspecialchars($row['rodzaj_paliwa']) ?>"><?= htmlspecialchars($row['rodzaj_paliwa']) ?></option>
        <?php endwhile; ?>
    </select>

    <select name="rocznik">
        <option value="">Rocznik</option>
        <?php while ($row = $stmt_rocznik->fetch()): ?>
            <option value="<?= htmlspecialchars($row['rok_produkcji']) ?>"><?= htmlspecialchars($row['rok_produkcji']) ?></option>
        <?php endwhile; ?>
    </select>

    <?php if ($selected_location): ?>
        <!-- Przekazujemy id_lokacji do search.php, aby filtrować tam po lokalizacji -->
        <input type="hidden" name="id_lokacji" value="<?= (int)$id_lokacji ?>">
    <?php endif; ?>

    <button type="submit">Szukaj</button>
</form>

<h2>Polecane samochody</h2>
<div class="car-grid">
    <?php while ($car = $stmt_recommended->fetch()): ?>
        <div class="car-card">
            <img src="../assets/car_place.png" alt="<?= htmlspecialchars($car['model']) ?>">
            <h3><?= htmlspecialchars($car['marka'] . ' ' . $car['model']) ?></h3>
            <p><strong><?= number_format($car['cena'], 0, ',', ' ') ?> zł</strong></p>
            <p><?= number_format($car['przebieg'], 0, ',', ' ') ?> km</p>
            <p><?= htmlspecialchars($car['rodzaj_paliwa']) ?></p>
            <a href="szczegoly.php?id=<?= urlencode($car['id_pojazdu']) ?>" 
               style="display: inline-block; padding: 10px 20px; background: #d80000; color: white; border-radius: 8px; text-decoration: none; font-weight: bold;">
               Zobacz więcej
            </a>
        </div>
    <?php endwhile; ?>
</div>

<div class="filters">
    <h2>Filtruj po lokalizacji</h2>
    <?php
    // resetujemy wynik, bo wcześniej iterowaliśmy
    $stmt_locations->execute();
    while ($row = $stmt_locations->fetch()):
    ?>
        <a href="?id_lokacji=<?= (int)$row['id_lokacji'] ?>" 
           style="display:inline-block; margin: 5px; padding: 8px 15px; background: #d80000; color: white; border-radius: 5px; text-decoration: none;">
           <?= htmlspecialchars($row['miasto']) ?>
        </a>
    <?php endwhile; ?>
</div>

<div class="why-us">
    <h2>Dlaczego my?</h2>
    <ul>
        <li>Sprawdzone pojazdy</li>
        <li>Pełna historia serwisowa</li>
        <li>Bezpieczne transakcje</li>
        <li>Szybka obsługa</li>
    </ul>
</div>

<div class="testimonial">
    <h2>Opinie klientów</h2>
    <p>“Bardzo profesjonalna obsługa i szybki kontakt. Auto w idealnym stanie. Polecam z całego serca!”</p>
    <p><strong>Jan Kowalski, Warszawa</strong> – 20.03.2025</p>
    <button>Zobacz więcej</button>
</div>

<div class="contact-form">
    <h2>Formularz kontaktowy</h2>
    <form method="POST" action="kontakt.php">
        <input type="text" name="name" placeholder="Imię i Nazwisko" required><br><br>
        <input type="email" name="email" placeholder="Email" required><br><br>
        <input type="tel" name="telefon" placeholder="Telefon"><br><br>
        <textarea name="wiadomosc" placeholder="Wiadomość" rows="5" required></textarea><br><br>
        <button type="submit">Skontaktuj się</button>
    </form>
</div>

<script>
// Dynamiczne ładowanie modeli
document.getElementById('marka').addEventListener('change', function () {
    const selectedMarka = this.value;
    const modelSelect = document.getElementById('model');
    modelSelect.innerHTML = '<option value="">Wczytywanie...</option>';
    modelSelect.disabled = true;

    if (selectedMarka) {
        fetch('../functions/get_models.php?marka=' + encodeURIComponent(selectedMarka))
            .then(response => response.json())
            .then(models => {
                modelSelect.innerHTML = '<option value="">Model</option>';
                models.forEach(model => {
                    const option = document.createElement('option');
                    option.value = model;
                    option.textContent = model;
                    modelSelect.appendChild(option);
                });
                modelSelect.disabled = false;
            });
    } else {
        modelSelect.innerHTML = '<option value="">Model</option>';
        modelSelect.disabled = true;
    }
});
</script>

<?php include '../includes/footer.php'; ?>
