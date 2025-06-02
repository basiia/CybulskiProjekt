<?php
session_start();
include '../includes/db.php';
include '../includes/header.php';

$stmt_marki     = $pdo->query("SELECT DISTINCT marka FROM Pojazdy");
$stmt_paliwa    = $pdo->query("SELECT DISTINCT rodzaj_paliwa FROM Pojazdy");
$stmt_rocznik   = $pdo->query("SELECT DISTINCT rok_produkcji FROM Pojazdy ORDER BY rok_produkcji DESC");
$stmt_locations = $pdo->query("SELECT id_lokacji, miasto FROM Lokacje");

$selected_marka = $_GET['marka'] ?? '';
$models = [];
if (!empty($selected_marka)) {
    $stmt_models = $pdo->prepare("SELECT DISTINCT model FROM Pojazdy WHERE marka = ?");
    $stmt_models->execute([$selected_marka]);
    $models = $stmt_models->fetchAll(PDO::FETCH_COLUMN);
}

$stmt_opinia = $pdo->query("SELECT * FROM opinie ORDER BY RAND() LIMIT 1");
$opinia = $stmt_opinia->fetch(PDO::FETCH_ASSOC);

$stmt_recommended = $pdo->query("SELECT * FROM Pojazdy WHERE status = 'Dostępny' ORDER BY RAND() LIMIT 3");
?>

<main>
    <section class="hero">
        <div class="hero-text">
            <h1>Znajdź swój<br>idealny samochód</h1>
            <form method="GET" action="index.php" class="search-bar">
                <div class="search-row">
                    <select name="marka" onchange="this.form.submit()">
                        <option value="">Marka</option>
                        <?php $stmt_marki->execute(); while ($row = $stmt_marki->fetch()): ?>
                            <option value="<?= htmlspecialchars($row['marka']) ?>" <?= $selected_marka === $row['marka'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['marka']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>

                    <select name="model" <?= empty($models) ? 'disabled' : '' ?>>
                        <option value="">Model</option>
                        <?php foreach ($models as $model): ?>
                            <option value="<?= htmlspecialchars($model) ?>" <?= ($_GET['model'] ?? '') === $model ? 'selected' : '' ?>>
                                <?= htmlspecialchars($model) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <select name="paliwo">
                        <option value="">Paliwo</option>
                        <?php $stmt_paliwa->execute(); while ($row = $stmt_paliwa->fetch()): ?>
                            <option value="<?= htmlspecialchars($row['rodzaj_paliwa']) ?>" <?= ($_GET['paliwo'] ?? '') === $row['rodzaj_paliwa'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['rodzaj_paliwa']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>

                    <select name="rocznik">
                        <option value="">Rocznik</option>
                        <?php $stmt_rocznik->execute(); while ($row = $stmt_rocznik->fetch()): ?>
                            <option value="<?= htmlspecialchars($row['rok_produkcji']) ?>" <?= ($_GET['rocznik'] ?? '') === $row['rok_produkcji'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['rok_produkcji']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="search-bottom">
                    <button type="submit" formaction="search.php">Szukaj</button>
                </div>
                <div class="advanced-search">
                    <img src="../assets/filter-icon.png" alt="Filtr" class="filter-icon">
                    <a href="search.php">Zaawansowane wyszukiwanie</a>
                </div>
            </form>
        </div>
        <div class="hero-image">
            <img src="../assets/car.png" alt="Car">
        </div>
    </section>

    <h2 class="section-title">Polecane samochody</h2>
    <div class="car-grid">
        <?php while ($car = $stmt_recommended->fetch()): ?>
            <div class="car-card">
                <img src="../assets/car_place.png" alt="<?= htmlspecialchars($car['model']) ?>">
                <h3><?= htmlspecialchars($car['marka'] . ' ' . $car['model']) ?></h3>
                <p class="price"><?= number_format($car['cena'], 0, ',', ' ') ?> zł</p>
                <p><?= number_format($car['przebieg'], 0, ',', ' ') ?> km</p>
                <p><?= htmlspecialchars($car['rodzaj_paliwa']) ?></p>
                <a href="szczegoly.php?id=<?= urlencode($car['id_pojazdu']) ?>" class="btn">Zobacz więcej</a>
            </div>
        <?php endwhile; ?>
    </div>

    <div class="two-columns">
        <div class="filters">
            <h2>Filtruj po lokalizacji</h2>
            <form method="get" action="search.php" class="location-form">
                <?php $stmt_locations->execute(); while ($row = $stmt_locations->fetch()): ?>
                    <button type="submit" name="id_lokacji" value="<?= (int)$row['id_lokacji'] ?>" class="location-btn">
                        <?= htmlspecialchars($row['miasto']) ?>
                    </button>
                <?php endwhile; ?>
            </form>
        </div>

        <div class="why-us">
            <h2>Dlaczego my?</h2>
            <ul>
                <li>✔ Sprawdzone pojazdy</li>
                <li>✔ Pełna historia serwisowa</li>
                <li>✔ Bezpieczne transakcje</li>
                <li>✔ Szybka obsługa</li>
            </ul>
        </div>
    </div>

    <?php if ($opinia): ?>
    <div class="testimonial-contact-container">
        <div class="testimonial">
            <h2>Opinie klientów</h2>
            <blockquote><?= htmlspecialchars($opinia['tresc']) ?></blockquote>
            <p><strong><?= htmlspecialchars($opinia['imie_nazwisko']) ?>, <?= htmlspecialchars($opinia['miasto']) ?></strong> – <?= date('d.m.Y', strtotime($opinia['data_opinii'])) ?></p>
            <a href="opinie.php" class="btn">Zobacz więcej</a>
        </div>

        <div class="contact-section">
            <h2>Formularz kontaktowy</h2>
            <form method="POST" action="../functions/kontakt.php" id="contactForm">
                <input type="text" name="name" placeholder="Imię i Nazwisko" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="tel" name="telefon" placeholder="Telefon">
                <textarea name="wiadomosc" placeholder="Wiadomość" rows="5" required></textarea>
                <button type="submit">Skontaktuj się</button>
            </form>
        </div>
    </div>
    <?php endif; ?>
</main>

<div id="successModal" class="modal">
  <div class="modal-content">
    <span class="close-button" id="closeModal">&times;</span>
    <h2>Dziękujemy za wiadomość!</h2>
    <p>Odezwiemy się do Ciebie jak najszybciej.</p>
  </div>
</div>

<script>
document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const form = this;
    const formData = new FormData(form);
    const modal = document.getElementById('successModal');
    const closeBtn = document.getElementById('closeModal');

    fetch(form.action, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            modal.style.display = 'block';
            form.reset();
        } else {
            alert('Błąd: ' + (data.message || 'Coś poszło nie tak.'));
        }
    })
    .catch(() => {
        alert('Błąd połączenia z serwerem.');
    });

    closeBtn.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
});
</script>

<?php include '../includes/footer.php'; ?>
