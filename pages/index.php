<?php
include '../includes/db.php';
include '../includes/header.php';

// Pobieranie danych do formularza
$sql_marki = "SELECT DISTINCT marka FROM Pojazdy";
$stmt_marki = $pdo->query($sql_marki);

$sql_modele = "SELECT DISTINCT model FROM Pojazdy";
$stmt_modele = $pdo->query($sql_modele);

$sql_paliwa = "SELECT DISTINCT rodzaj_paliwa FROM Pojazdy";
$stmt_paliwa = $pdo->query($sql_paliwa);

$sql_rocznik = "SELECT DISTINCT rok_produkcji FROM Pojazdy ORDER BY rok_produkcji DESC";
$stmt_rocznik = $pdo->query($sql_rocznik);

// Polecane pojazdy
$sql_recommended = "SELECT * FROM Pojazdy WHERE status = 'Dostępny' ORDER BY RAND() LIMIT 3";
$stmt_recommended = $pdo->query($sql_recommended);

// Lokacje
$sql_locations = "SELECT DISTINCT miasto FROM Lokacje";
$stmt_locations = $pdo->query($sql_locations);
?>

<h1>Znajdź swój idealny samochód</h1>
<form class="search-bar" method="GET" action="search.php">
    <select name="marka">
        <option>Marka</option>
        <?php while ($row = $stmt_marki->fetch()) echo "<option>{$row['marka']}</option>"; ?>
    </select>
    <select name="model">
        <option>Model</option>
        <?php while ($row = $stmt_modele->fetch()) echo "<option>{$row['model']}</option>"; ?>
    </select>
    <select name="paliwo">
        <option>Paliwo</option>
        <?php while ($row = $stmt_paliwa->fetch()) echo "<option>{$row['rodzaj_paliwa']}</option>"; ?>
    </select>
    <select name="rocznik">
        <option>Rocznik</option>
        <?php while ($row = $stmt_rocznik->fetch()) echo "<option>{$row['rok_produkcji']}</option>"; ?>
    </select>
    <button type="submit">Szukaj</button>
</form>

<h2>Polecane samochody</h2>
<div class="car-grid">
<?php while ($car = $stmt_recommended->fetch()) { ?>
    <div class="car-card">
        <img src="../assets/car_place.png" alt="<?php echo $car['model']; ?>">
        <h3><?php echo $car['marka'] . ' ' . $car['model']; ?></h3>
        <p><strong><?php echo number_format($car['cena'], 0, ',', ' '); ?> zł</strong></p>
        <p><?php echo number_format($car['przebieg'], 0, ',', ' '); ?> km</p>
        <p><?php echo $car['rodzaj_paliwa']; ?></p>
        <button>Zobacz więcej</button>
    </div>
<?php } ?>
</div>

<div class="filters">
    <h2>Filtruj po lokalizacji</h2>
    <?php while ($row = $stmt_locations->fetch()) { ?>
        <button><?php echo $row['miasto']; ?></button>
    <?php } ?>
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

<?php include '../includes/footer.php'; ?>
