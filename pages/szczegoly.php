<?php include '../includes/header.php'; ?>
<?php
include '../includes/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "
    SELECT p.*, l.nazwa AS nazwa_lokacji, l.adres, l.miasto, l.kod_pocztowy 
    FROM Pojazdy p 
    JOIN lokacje l ON p.id_lokacji = l.id_lokacji 
    WHERE p.id_pojazdu = :id
";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $pojazd = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($pojazd) {
        // Przygotuj status i klasę CSS
        $status_tekst = htmlspecialchars($pojazd['status']);
        $status_klasa = '';
        if ($pojazd['status'] === 'Zarezerwowany') {
            $status_klasa = 'status-zarezerwowany';
        } elseif ($pojazd['status'] === 'Dostępny') {
            $status_klasa = 'status-dostepny';
        } else {
            $status_klasa = 'status-inny';
        }

        echo "<div class='vehicle-details'>";
        echo "<h1 class='vehicle-title'>" . htmlspecialchars($pojazd['marka']) . " " . htmlspecialchars($pojazd['model']);
        echo " <span class='vehicle-status-badge {$status_klasa}'>" . $status_tekst . "</span>";
        echo "</h1>";

        echo "<div class='vehicle-summary'>";
        echo "<div class='vehicle-image'>";
        echo "<img src='../assets/car_place.png' alt='Zdjęcie pojazdu'>";
        echo "</div>";
        echo "<div class='vehicle-info'>";
        echo "<p><strong>Rok produkcji:</strong> " . htmlspecialchars($pojazd['rok_produkcji']) . "</p>";
        echo "<p><strong>Przebieg:</strong> " . number_format($pojazd['przebieg'], 0, ',', '.') . " km</p>";
        echo "<p><strong>Cena:</strong> " . number_format($pojazd['cena'], 2, ',', '.') . " PLN</p>";
        echo "<p><strong>Rodzaj paliwa:</strong> " . htmlspecialchars($pojazd['rodzaj_paliwa']) . "</p>";
        echo "<p><strong>Typ pojazdu:</strong> " . htmlspecialchars($pojazd['typ_pojazdu']) . "</p>";
        echo "<p><strong>Oddział:</strong> " . htmlspecialchars($pojazd['nazwa_lokacji']) . "</p>";
        echo "</div>";
        echo "</div>"; // .vehicle-summary

        echo "<div class='vehicle-specs'>";
        echo "<h3>Szczegóły pojazdu</h3>";
        echo "<p><strong>Kolor:</strong> " . htmlspecialchars($pojazd['kolor']) . "</p>";
        echo "<p><strong>Rodzaj nadwozia:</strong> " . htmlspecialchars($pojazd['rodzaj_nadwozia']) . "</p>";
        echo "<p><strong>Pojemność silnika:</strong> " . htmlspecialchars($pojazd['pojemnosc_silnika']) . " L</p>";
        echo "<p><strong>Moc:</strong> " . htmlspecialchars($pojazd['moc_kw']) . " kW</p>";
        echo "<p><strong>VIN:</strong> " . htmlspecialchars($pojazd['vin']) . "</p>";
        echo "<p><strong>Skrzynia biegów:</strong> " . htmlspecialchars($pojazd['skrzynia_biegow']) . "</p>";
        echo "<p><strong>Napęd:</strong> " . htmlspecialchars($pojazd['naped']) . "</p>";
        echo "<p><strong>Kierownica:</strong> " . ($pojazd['kierownica_prawa'] ? 'Prawa' : 'Lewa') . "</p>";
        echo "<p><strong>Liczba drzwi:</strong> " . htmlspecialchars($pojazd['liczba_drzwi']) . "</p>";
        echo "<p><strong>Liczba miejsc:</strong> " . htmlspecialchars($pojazd['liczba_miejsc']) . "</p>";
        echo "<p><strong>Kraj pochodzenia:</strong> " . htmlspecialchars($pojazd['kraj_pochodzenia']) . "</p>";
        echo "<p><strong>Data pierwszej rejestracji:</strong> " . date('d-m-Y', strtotime($pojazd['data_pierwszej_rejestracji'])) . "</p>";
        echo "<p><strong>Numer rejestracyjny:</strong> " . htmlspecialchars($pojazd['numer_rejestracyjny']) . "</p>";
        echo "<p><strong>Stan techniczny:</strong> " . htmlspecialchars($pojazd['stan_techniczny']) . "</p>";
        echo "</div>"; // .vehicle-specs

        if ($pojazd['wyposazenie_dodatkowe']) {
            echo "<div class='vehicle-extra-equipment'>";
            echo "<h3>Wyposażenie dodatkowe</h3>";
            echo "<p>" . nl2br(htmlspecialchars($pojazd['wyposazenie_dodatkowe'])) . "</p>";
            echo "</div>"; // .vehicle-extra-equipment
        }

        // --- HISTORIA PRZEGLĄDÓW (3 ostatnie wpisy) ---
        $sql_przeglady = "SELECT data_przegladu, przebieg, wynik, uwagi FROM historiaprzegladow WHERE id_pojazdu = :id ORDER BY data_przegladu DESC LIMIT 3";
        $stmt_przeglady = $pdo->prepare($sql_przeglady);
        $stmt_przeglady->bindParam(':id', $pojazd['id_pojazdu']);
        $stmt_przeglady->execute();
        $przeglady = $stmt_przeglady->fetchAll(PDO::FETCH_ASSOC);

        if ($przeglady) {
            echo "<div class='vehicle-inspection-history'>";
            echo "<h3>Historia przeglądów</h3>";
            echo "<ul>";
            foreach ($przeglady as $przeglad) {
                echo "<li>";
                echo "<strong>" . date('d-m-Y', strtotime($przeglad['data_przegladu'])) . "</strong>";
                echo " - Przebieg: " . number_format($przeglad['przebieg'], 0, ',', '.') . " km";
                echo " - Wynik: " . htmlspecialchars($przeglad['wynik']);
                if (!empty($przeglad['uwagi'])) {
                    echo "<br>" . nl2br(htmlspecialchars($przeglad['uwagi']));
                }
                echo "</li>";
            }
            echo "</ul>";
            echo "<a class='btn-see-more' href='historia_przegladow.php?id=" . $pojazd['id_pojazdu'] . "'>Zobacz więcej</a>";
            echo "</div>";
        }

        // --- HISTORIA SERWISOWA (3 ostatnie wpisy) ---
        $sql_serwis = "SELECT data_serwisu, opis, koszt, odpowiedzialny_serwis FROM historiaserwisowa WHERE id_pojazdu = :id ORDER BY data_serwisu DESC LIMIT 3";
        $stmt_serwis = $pdo->prepare($sql_serwis);
        $stmt_serwis->bindParam(':id', $pojazd['id_pojazdu']);
        $stmt_serwis->execute();
        $serwisy = $stmt_serwis->fetchAll(PDO::FETCH_ASSOC);

        if ($serwisy) {
            echo "<div class='vehicle-maintenance-history'>";
            echo "<h3>Historia serwisowa</h3>";
            echo "<ul>";
            foreach ($serwisy as $serwis) {
                echo "<li>";
                echo "<strong>" . date('d-m-Y', strtotime($serwis['data_serwisu'])) . "</strong>";
                echo " - Koszt: " . number_format($serwis['koszt'], 2, ',', '.') . " PLN";
                echo "<br><strong>Opis:</strong> " . nl2br(htmlspecialchars($serwis['opis']));
                if (!empty($serwis['odpowiedzialny_serwis'])) {
                    echo "<br><em>Odpowiedzialny serwis:</em> " . htmlspecialchars($serwis['odpowiedzialny_serwis']);
                }
                echo "</li>";
            }
            echo "</ul>";
            echo "<a class='btn-see-more' href='historia_serwisowa.php?id=" . $pojazd['id_pojazdu'] . "'>Zobacz więcej</a>";
            echo "</div>";
        }

        // Przycisk rezerwacji - tylko jeśli pojazd NIE jest zarezerwowany
        if ($pojazd['status'] !== 'Zarezerwowany') {
            echo "<a class='btn-reserve' href='rezerwacja.php?id=" . $pojazd['id_pojazdu'] . "'>Zarezerwuj pojazd</a>";
        } else {
            echo "<p style='color:#dc3545; font-weight:bold; margin-top:20px;'>Pojazd jest aktualnie zarezerwowany.</p>";
        }

        echo "</div>"; // .vehicle-details

        // Zapytanie o podobne pojazdy
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
    font-size: 1.1rem;
    font-weight: 600;
    padding: 4px 12px;
    border-radius: 20px;
    color: white;
    user-select: none;
}
.status-zarezerwowany {
    background-color: #dc3545; /* czerwony */
}
.status-dostepny {
    background-color: #198754; /* zielony */
}
.status-inny {
    background-color: #6c757d; /* szary */
}
.vehicle-specs {
    margin-top: 30px;
    border-top: 1px solid #ddd;
    padding-top: 20px;
}
.vehicle-specs p {
    margin: 6px 0;
    font-size: 1.05rem;
}
.vehicle-extra-equipment {
    margin-top: 25px;
    padding: 15px;
    background-color: #f8f9fa;
    border-radius: 8px;
}
.vehicle-inspection-history, .vehicle-maintenance-history {
    margin-top: 30px;
    background-color: #f9fafb;
    padding: 20px;
    border-radius: 8px;
    border: 1px solid #ddd;
}

.vehicle-inspection-history h3,
.vehicle-maintenance-history h3 {
    margin-bottom: 15px;
    font-size: 1.6rem;
    color: #333;
}

.vehicle-inspection-history ul,
.vehicle-maintenance-history ul {
    list-style: disc inside;
    margin-left: 0;
    padding-left: 0;
    font-size: 1.05rem;
    line-height: 1.4;
    color: #555;
}

.vehicle-inspection-history li,
.vehicle-maintenance-history li {
    margin-bottom: 14px;
    padding-bottom: 6px;
    border-bottom: 1px solid #eee;
}

.vehicle-inspection-history li:last-child,
.vehicle-maintenance-history li:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}

.btn-see-more {
    display: inline-block;
    margin-top: 8px;
    font-weight: 600;
    color: #0d6efd;
    text-decoration: underline;
    cursor: pointer;
    transition: color 0.3s ease;
}
.btn-see-more:hover {
    color: #0847c7;
}

.btn-reserve {
    margin-top: 30px;
    display: inline-block;
    padding: 12px 24px;
    background-color: #0d6efd;
    color: white;
    border-radius: 6px;
    font-weight: 700;
    text-decoration: none;
    transition: background-color 0.3s ease;
}
.btn-reserve:hover {
    background-color: #0847c7;
}
.similar-vehicles {
    margin-top: 50px;
}
.similar-vehicles h2 {
    margin-bottom: 25px;
}
.vehicle-list {
    display: flex;
    gap: 25px;
    flex-wrap: wrap;
}
.vehicle-item {
    width: calc(33% - 16px);
    background-color: #f8f9fa;
    border-radius: 8px;
    padding: 15px;
    text-align: center;
    box-shadow: 0 0 8px rgba(0,0,0,0.05);
    transition: box-shadow 0.2s ease;
}
.vehicle-item:hover {
    box-shadow: 0 0 16px rgba(0,0,0,0.15);
}
.vehicle-thumbnail {
    width: 100%;
    height: 180px;
    object-fit: contain;
    margin-bottom: 12px;
    border-radius: 6px;
}
.price {
    font-size: 1.2rem;
    font-weight: 700;
    color: #198754;
    margin: 10px 0;
}
.details-link {
    color: #0d6efd;
    font-weight: 600;
    text-decoration: none;
}
.details-link:hover {
    text-decoration: underline;
}
</style>
