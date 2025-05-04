<?php include '../includes/header.php'; ?>
<?php
include '../includes/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM Pojazdy WHERE id_pojazdu = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $pojazd = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($pojazd) {
        echo "<div class='vehicle-details'>";
        echo "<h1>" . $pojazd['marka'] . " " . $pojazd['model'] . "</h1>";
        echo "<div class='vehicle-summary'>";
        echo "<div class='vehicle-image'>";
        echo "<img src='../assets/car_place.png' alt='Zdjęcie pojazdu'>";
        echo "</div>";
        echo "<div class='vehicle-info'>";
        echo "<p><strong>Rok produkcji:</strong> " . $pojazd['rok_produkcji'] . "</p>";
        echo "<p><strong>Przebieg:</strong> " . number_format($pojazd['przebieg'], 0, ',', '.') . " km</p>";
        echo "<p><strong>Cena:</strong> " . number_format($pojazd['cena'], 2, ',', '.') . " PLN</p>";
        echo "<p><strong>Rodzaj paliwa:</strong> " . $pojazd['rodzaj_paliwa'] . "</p>";
        echo "<p><strong>Typ pojazdu:</strong> " . $pojazd['typ_pojazdu'] . "</p>";
        echo "</div>";
        echo "</div>"; // .vehicle-summary
        
        echo "<div class='vehicle-specs'>";
        echo "<h3>Szczegóły pojazdu</h3>";
        echo "<p><strong>Kolor:</strong> " . $pojazd['kolor'] . "</p>";
        echo "<p><strong>Rodzaj nadwozia:</strong> " . $pojazd['rodzaj_nadwozia'] . "</p>";
        echo "<p><strong>Pojemność silnika:</strong> " . $pojazd['pojemnosc_silnika'] . " L</p>";
        echo "<p><strong>Moc:</strong> " . $pojazd['moc_kw'] . " kW</p>";
        echo "<p><strong>VIN:</strong> " . $pojazd['vin'] . "</p>";
        echo "<p><strong>Skrzynia biegów:</strong> " . $pojazd['skrzynia_biegow'] . "</p>";
        echo "<p><strong>Napęd:</strong> " . $pojazd['naped'] . "</p>";
        echo "<p><strong>Kierownica:</strong> " . ($pojazd['kierownica_prawa'] ? 'Prawa' : 'Lewa') . "</p>";
        echo "<p><strong>Liczba drzwi:</strong> " . $pojazd['liczba_drzwi'] . "</p>";
        echo "<p><strong>Liczba miejsc:</strong> " . $pojazd['liczba_miejsc'] . "</p>";
        echo "<p><strong>Kraj pochodzenia:</strong> " . $pojazd['kraj_pochodzenia'] . "</p>";
        echo "<p><strong>Data pierwszej rejestracji:</strong> " . date('d-m-Y', strtotime($pojazd['data_pierwszej_rejestracji'])) . "</p>";
        echo "<p><strong>Numer rejestracyjny:</strong> " . $pojazd['numer_rejestracyjny'] . "</p>";
        echo "<p><strong>Stan techniczny:</strong> " . $pojazd['stan_techniczny'] . "</p>";
        echo "</div>"; // .vehicle-specs
        
        if ($pojazd['wyposazenie_dodatkowe']) {
            echo "<div class='vehicle-extra-equipment'>";
            echo "<h3>Wyposażenie dodatkowe</h3>";
            echo "<p>" . nl2br($pojazd['wyposazenie_dodatkowe']) . "</p>";
            echo "</div>"; // .vehicle-extra-equipment
        }
        
        echo "<a class='btn-reserve' href='rezerwacja.php?id=" . $pojazd['id_pojazdu'] . "'>Zarezerwuj pojazd</a>";
        echo "</div>"; // .vehicle-details
        
        // Zapytanie o podobne pojazdy na podstawie typu pojazdu, liczby drzwi, i roku produkcji
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

        if ($similar_vehicles) {
            echo "<div class='similar-vehicles'>";
            echo "<h2>Podobne pojazdy</h2>";
            echo "<div class='vehicle-list'>";
            foreach ($similar_vehicles as $similar) {
                echo "<div class='vehicle-item'>";
                echo "<img src='../assets/car_place.png' alt='Zdjęcie pojazdu' class='vehicle-thumbnail'>";
                echo "<h3>" . htmlspecialchars($similar['marka']) . " " . htmlspecialchars($similar['model']) . "</h3>";
                echo "<p>Rok produkcji: " . htmlspecialchars($similar['rok_produkcji']) . "</p>";
                echo "<p>Przebieg: " . number_format($similar['przebieg'], 0, ',', '.') . " km</p>";
                echo "<p class='price'>" . number_format($similar['cena'], 2, ',', '.') . " PLN</p>";
                echo "<a class='details-link' href='szczegoly.php?id=" . $similar['id_pojazdu'] . "'>Zobacz szczegóły</a>";
                echo "</div>";
            }
            
            echo "</div>";
            echo "</div>"; // .similar-vehicles
        }

    } else {
        echo "<p>Nie znaleziono pojazdu o takim ID.</p>";
    }
} else {
    echo "<p>Brak ID pojazdu w zapytaniu.</p>";
}
?>
<?php include '../includes/footer.php'; ?>

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
    margin-bottom: 30px;
}

.vehicle-image img {
    width: 100%;
    max-width: 500px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.vehicle-info p {
    font-size: 18px;
    line-height: 1.6;
}

.vehicle-specs h3,
.vehicle-extra-equipment h3 {
    font-size: 20px;
    margin-top: 20px;
    font-weight: bold;
}

.vehicle-specs p {
    font-size: 16px;
    margin: 8px 0;
}

.btn-reserve {
    display: inline-block;
    margin-top: 20px;
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
}

.btn-reserve:hover {
    background-color: #0056b3;
}

.similar-vehicles {
    margin-top: 50px;
    padding: 20px;
    background-color: #f8f9fa;
    border-radius: 8px;
}

.similar-vehicles h2 {
    font-size: 24px;
    margin-bottom: 20px;
    text-align: center;
}

.vehicle-list {
    display: flex;
    justify-content: space-between;
    gap: 20px;
    flex-wrap: wrap;
}

.vehicle-item h3 {
    font-size: 18px;
    margin: 10px 0 5px;
}

.vehicle-item .price {
    font-weight: bold;
    margin: 10px 0;
}

.details-link {
    display: inline-block;
    margin-top: 10px;
    padding: 8px 12px;
    background-color: #007bff;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    font-size: 14px;
}

.details-link:hover {
    background-color: #0056b3;
}

</style>
