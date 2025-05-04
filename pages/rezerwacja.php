<?php include '../includes/header.php'; ?>
<?php
include '../includes/db.php';

if (!isset($_SESSION['id_user'])) {
    echo "Dostęp tylko dla zalogowanych klientów.";
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Sprawdzamy, czy pojazd istnieje
    $sql = "SELECT * FROM Pojazdy WHERE id_pojazdu = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $pojazd = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($pojazd) {
        // Wyświetlamy szczegóły pojazdu
        echo "<div class='vehicle-details'>";
        echo "<h1>Rezerwacja pojazdu: " . $pojazd['marka'] . " " . $pojazd['model'] . "</h1>";
        echo "<img src='../assets/car_place.png' alt='" . $pojazd['marka'] . " " . $pojazd['model'] . "' class='vehicle-image'>";


        // Szczegóły pojazdu
        echo "<p><strong>Cena:</strong> " . $pojazd['cena'] . " PLN</p>";
        echo "<p><strong>Rok produkcji:</strong> " . $pojazd['rok_produkcji'] . "</p>";
        echo "<p><strong>Przebieg:</strong> " . $pojazd['przebieg'] . " km</p>";
        echo "<p><strong>Typ paliwa:</strong> " . $pojazd['rodzaj_paliwa'] . "</p>";
        echo "</div>";

        // Formularz rezerwacji
        echo "<form method='POST' action='../functions/zarejestruj_rezerwacje.php' class='reservation-form'>";
        echo "<input type='hidden' name='id_pojazdu' value='" . $pojazd['id_pojazdu'] . "'>";
        echo "<input type='hidden' name='id_user' value='" . $_SESSION['id_user'] . "'>";
        
        // Pola formularza
        echo "<label for='data_rezerwacji'>Data rezerwacji:</label><br>";
        echo "<input type='date' name='data_rezerwacji' required><br>";

        echo "<label for='zaliczka'>Wybierz procent zaliczki:</label><br>";
        echo "<select id='zaliczka_procent' name='zaliczka_procent' required>";
        echo "<option value='5'>5%</option>";
        echo "<option value='10'>10%</option>";
        echo "<option value='15'>15%</option>";
        echo "<option value='20'>20%</option>";
        echo "</select><br>";

        echo "<label for='zaliczka_wartosc'>Wielkość zaliczki (PLN):</label><br>";
        echo "<input type='text' id='zaliczka_wartosc' name='wielkosc_zaliczki' readonly><br>";

        // Skrypt do obliczania zaliczki
        echo "<script>
            const cenaPojazdu = " . $pojazd['cena'] . ";
            const zaliczkaSelect = document.getElementById('zaliczka_procent');
            const zaliczkaWartosc = document.getElementById('zaliczka_wartosc');
            
            function updateZaliczka() {
                const procent = zaliczkaSelect.value;
                const wartoscZaliczki = (cenaPojazdu * procent) / 100;
                zaliczkaWartosc.value = wartoscZaliczki.toFixed(2) + ' PLN';
            }
            
            // Wywołanie funkcji po załadowaniu strony
            updateZaliczka();
            
            // Zaktualizuj wartość zaliczki przy zmianie procentu
            zaliczkaSelect.addEventListener('change', updateZaliczka);
        </script>";

        echo "<input type='submit' value='Zarezerwuj' class='submit-btn'>";
        echo "</form>";
    } else {
        echo "<p>Nie znaleziono pojazdu do rezerwacji.</p>";
    }
} else {
    echo "<p>Brak ID pojazdu w zapytaniu.</p>";
}
?>
<?php include '../includes/footer.php'; ?>


<style>
    /* Stylowanie detali pojazdu */
    .vehicle-details {
        margin: 20px;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 10px;
        background-color: #f9f9f9;
    }

    .vehicle-image {
        max-width: 100%;
        height: auto;
        margin-bottom: 15px;
        border-radius: 10px;
    }

    .reservation-form {
        margin-top: 20px;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 10px;
        background-color: #f9f9f9;
    }

    .reservation-form label {
        font-weight: bold;
        margin-top: 10px;
    }

    .reservation-form input[type="date"],
    .reservation-form select,
    .reservation-form input[type="text"],
    .reservation-form input[type="submit"] {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    .reservation-form input[type="submit"] {
        background-color: #4CAF50;
        color: white;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .reservation-form input[type="submit"]:hover {
        background-color: #45a049;
    }
</style>
