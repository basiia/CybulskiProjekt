<?php include '../includes/header.php'; ?>
<?php
include '../includes/db.php';

if (!isset($_SESSION['id_user'])) {
    echo "<p>Dostęp tylko dla zalogowanych klientów.</p>";
    include '../includes/footer.php';
    exit;
}

if (isset($_GET['id'])) {
    $id = (int)$_GET['id']; // Cast na int dla bezpieczeństwa

    // Sprawdzamy, czy pojazd istnieje
    $sql = "SELECT * FROM Pojazdy WHERE id_pojazdu = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $pojazd = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($pojazd):
?>
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

            <input type="submit" value="Zarezerwuj" class="submit-btn">
        </form>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const cenaPojazdu = <?= json_encode($pojazd['cena']) ?>;
                const zaliczkaSelect = document.getElementById('zaliczka_procent');
                const zaliczkaWartosc = document.getElementById('zaliczka_wartosc');

                function updateZaliczka() {
                    const procent = parseFloat(zaliczkaSelect.value);
                    const wartosc = (cenaPojazdu * procent) / 100;
                    zaliczkaWartosc.value = wartosc.toFixed(2);
                }

                zaliczkaSelect.addEventListener('change', updateZaliczka);

                updateZaliczka();

                // Opcjonalnie: walidacja formularza przed wysłaniem
                document.getElementById('reservationForm').addEventListener('submit', (e) => {
                    if (!zaliczkaWartosc.value || isNaN(zaliczkaWartosc.value)) {
                        e.preventDefault();
                        alert("Niepoprawna wartość zaliczki.");
                    }
                });
            });
        </script>

<?php
    else:
        echo "<p>Nie znaleziono pojazdu do rezerwacji.</p>";
    endif;
} else {
    echo "<p>Brak ID pojazdu w zapytaniu.</p>";
}
include '../includes/footer.php';
?>

<style>
.vehicle-details {
    margin: 20px auto;
    padding: 20px;
    max-width: 600px;
    border: 1px solid #ddd;
    border-radius: 10px;
    background-color: #f9f9f9;
    font-family: Arial, sans-serif;
}
.vehicle-image {
    max-width: 100%;
    height: auto;
    margin-bottom: 15px;
    border-radius: 10px;
}
.reservation-form {
    margin: 20px auto;
    max-width: 600px;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 10px;
    background-color: #f9f9f9;
    font-family: Arial, sans-serif;
}
.reservation-form label {
    font-weight: bold;
    margin-top: 15px;
    display: block;
}
.reservation-form select,
.reservation-form input[type="text"],
.reservation-form input[type="submit"] {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    border-radius: 5px;
    border: 1px solid #ccc;
    box-sizing: border-box;
    font-size: 1rem;
}
.reservation-form input[type="submit"] {
    background-color: #4CAF50;
    color: white;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s ease;
    margin-top: 20px;
}
.reservation-form input[type="submit"]:hover {
    background-color: #45a049;
}
</style>
