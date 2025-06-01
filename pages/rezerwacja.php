<?php
include '../includes/header.php';
include '../includes/db.php';

if (!isset($_SESSION['id_user'])) {
    echo "<p class='access-denied'>Dostęp tylko dla zalogowanych klientów.</p>";
    include '../includes/footer.php';
    exit;
}

if (!isset($_GET['id'])) {
    echo "<p class='access-denied'>Brak ID pojazdu w zapytaniu.</p>";
    include '../includes/footer.php';
    exit;
}

$id = (int)$_GET['id'];

// Pobierz dane pojazdu
$stmt = $pdo->prepare("SELECT * FROM Pojazdy WHERE id_pojazdu = :id");
$stmt->execute([':id' => $id]);
$pojazd = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$pojazd) {
    echo "<p class='access-denied'>Nie znaleziono pojazdu do rezerwacji.</p>";
    include '../includes/footer.php';
    exit;
}
?>

<link rel="stylesheet" href="../styles/rezerwacja-styled.css">

<div class="vehicle-details">
    <h1>Rezerwacja pojazdu: <?= htmlspecialchars($pojazd['marka'] . ' ' . $pojazd['model']) ?></h1>

    <img src="../assets/car_place.png" alt="<?= htmlspecialchars($pojazd['marka'] . ' ' . $pojazd['model']) ?>" class="vehicle-image">

    <p><strong>Cena:</strong> <?= number_format($pojazd['cena'], 2, ',', '.') ?> PLN</p>
    <p><strong>Rok produkcji:</strong> <?= htmlspecialchars($pojazd['rok_produkcji']) ?></p>
    <p><strong>Przebieg:</strong> <?= number_format($pojazd['przebieg'], 0, ',', ' ') ?> km</p>
    <p><strong>Typ paliwa:</strong> <?= htmlspecialchars($pojazd['rodzaj_paliwa']) ?></p>
</div>

<form method="POST" action="../functions/zarejestruj_rezerwacje.php" class="reservation-form" id="reservationForm">
    <input type="hidden" name="id_pojazdu" value="<?= $pojazd['id_pojazdu'] ?>">
    <input type="hidden" name="id_user" value="<?= $_SESSION['id_user'] ?>">

    <label for="zaliczka_procent">Wybierz procent zaliczki:</label>
    <select id="zaliczka_procent" name="zaliczka_procent" required>
        <option value="5">5%</option>
        <option value="10">10%</option>
        <option value="15">15%</option>
        <option value="20">20%</option>
    </select>

    <label for="zaliczka_wartosc">Wielkość zaliczki (PLN):</label>
    <input type="text" id="zaliczka_wartosc" name="wielkosc_zaliczki" readonly required>

    <input type="submit" value="Zarezerwuj pojazd" class="submit-btn">
</form>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const cena = <?= json_encode($pojazd['cena']) ?>;
    const select = document.getElementById('zaliczka_procent');
    const input = document.getElementById('zaliczka_wartosc');

    function oblicz() {
        const procent = parseFloat(select.value);
        const wartosc = (cena * procent) / 100;
        input.value = wartosc.toFixed(2);
    }

    select.addEventListener('change', oblicz);
    oblicz();

    document.getElementById('reservationForm').addEventListener('submit', (e) => {
        if (!input.value || isNaN(input.value)) {
            e.preventDefault();
            alert("Niepoprawna wartość zaliczki.");
        }
    });
});
</script>

<?php include '../includes/footer.php'; ?>
