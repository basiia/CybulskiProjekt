<?php
include '../includes/db.php';

// Pobieranie dostępnych marek z bazy danych
$sql_marki = "SELECT DISTINCT marka FROM Pojazdy";
$stmt_marki = $pdo->query($sql_marki);

// Pobieranie dostępnych modeli z bazy danych
$sql_modele = "SELECT DISTINCT model FROM Pojazdy";
$stmt_modele = $pdo->query($sql_modele);

// Pobieranie dostępnych rodzajów paliwa
$sql_paliwa = "SELECT DISTINCT rodzaj_paliwa FROM Pojazdy";
$stmt_paliwa = $pdo->query($sql_paliwa);

// Pobieranie dostępnych roczników z bazy danych
$sql_rocznik = "SELECT DISTINCT rok_produkcji FROM Pojazdy ORDER BY rok_produkcji DESC";
$stmt_rocznik = $pdo->query($sql_rocznik);

// Pobieranie dostępnych pojazdów (3 losowe polecane pojazdy)
$sql_recommended = "SELECT * FROM Pojazdy WHERE status = 'Dostępny' ORDER BY RAND() LIMIT 3";
$stmt_recommended = $pdo->query($sql_recommended);

// Pobieranie miast z tabeli Lokacje do filtru lokalizacji
$sql_locations = "SELECT DISTINCT miasto FROM Lokacje";
$stmt_locations = $pdo->query($sql_locations);

// Funkcja do zwracania modeli i roczników
if (isset($_GET['marka'])) {
    $marka = $_GET['marka'];

    // Pobieranie pasujących modeli
    $sql_modele = "SELECT DISTINCT model FROM Pojazdy WHERE marka = :marka";
    $stmt_modele = $pdo->prepare($sql_modele);
    $stmt_modele->execute(['marka' => $marka]);
    $models = $stmt_modele->fetchAll(PDO::FETCH_COLUMN);

    // Zwracanie danych w formacie JSON
    echo json_encode(['models' => $models]);
    exit();
}
?>

<?php include '../includes/header.php'; ?>

<!-- Wyszukiwanie -->
<?php include '../functions/filters.php'; ?>

<!-- Polecane pojazdy -->
<div class="recommended-cars">
    <h2>Polecane pojazdy</h2>
    <div class="container">
        <?php
        if ($stmt_recommended->rowCount() > 0) {
            while ($row = $stmt_recommended->fetch(PDO::FETCH_ASSOC)) {
                echo '<div class="card">';
                echo '<img src="./assets/car_place.png" alt="Zdjęcie pojazdu">';
                echo '<h2>' . htmlspecialchars($row['marka']) . ' ' . htmlspecialchars($row['model']) . '</h2>';
                echo '<p>Rok produkcji: ' . htmlspecialchars($row['rok_produkcji']) . '</p>';
                echo '<p>Przebieg: ' . number_format($row['przebieg'], 0, ',', '.') . ' km</p>';
                echo '<p class="price">' . number_format($row['cena'], 2, ',', '.') . ' PLN</p>';
                echo '<a href="szczegoly.php?id=' . $row['id_pojazdu'] . '">Zobacz szczegóły</a>';
                echo '</div>';
            }
        } else {
            echo "<p>Brak polecanych pojazdów.</p>";
        }
        ?>
    </div>
</div>

<!-- Filtr lokalizacji -->
<div class="location-filter">
    <h2>Filtruj po lokalizacji</h2>
    <form action="filter.php" method="get">
        <div class="locations-buttons">
            <?php
            if ($stmt_locations->rowCount() > 0) {
                while ($row = $stmt_locations->fetch(PDO::FETCH_ASSOC)) {
                    echo '<button type="submit" name="miasto" value="' . htmlspecialchars($row['miasto']) . '">' . htmlspecialchars($row['miasto']) . '</button>';
                }
            }
            ?>
        </div>
    </form>
</div>


<!-- Formularz kontaktowy -->
<div class="contact-form">
    <h2>Skontaktuj się z nami</h2>
    <form action="contact.php" method="post">
        <input type="text" name="name" placeholder="Imię" required />
        <input type="email" name="email" placeholder="E-mail" required />
        <textarea name="message" placeholder="Twoja wiadomość" required></textarea>
        <button type="submit">Wyślij</button>
    </form>
</div>

<!-- Opinie klientów -->
<div class="customer-reviews">
    <h2>Opinie naszych klientów</h2>
    <div class="reviews">
        <!-- Przykładowe opinie -->
        <div class="review">
            <p>"Bardzo dobra obsługa, świetne pojazdy!" - Jan Kowalski</p>
        </div>
        <div class="review">
            <p>"Jestem bardzo zadowolony z zakupu!" - Anna Nowak</p>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>

<style>
/* Globalne style */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
}

/* Nagłówki */
h1, h2 {
    color: #333;
    text-align: center;
    margin-bottom: 20px;
}

/* Formularz wyszukiwania */
.search-bar {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    margin: 30px auto;
    width: 80%;
    max-width: 800px;
}

.search-bar select, .search-bar input[type="number"] {
    padding: 10px;
    margin: 10px 5px;
    width: 200px;
    border-radius: 5px;
    border: 1px solid #ccc;
    font-size: 16px;
}

.search-bar button {
    padding: 12px 20px;
    background-color: #007BFF;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}

.search-bar button:hover {
    background-color: #0056b3;
}

/* Polecane pojazdy */
.recommended-cars .container {
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap;
}

.recommended-cars .card {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    width: 300px;
    text-align: center;
    margin-bottom: 20px;
}

.recommended-cars .card img {
    max-width: 100%;
    border-radius: 8px;
}

.recommended-cars .card h2 {
    font-size: 20px;
    margin-top: 15px;
}

.recommended-cars .card .price {
    font-weight: bold;
    margin-top: 10px;
}

/* Formularz kontaktowy */
.contact-form {
    background-color: #fff;
    padding: 20px;
    margin-top: 30px;
    max-width: 500px;
    margin: 0 auto;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.contact-form input, .contact-form textarea {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border-radius: 5px;
    border: 1px solid #ccc;
}

.contact-form button {
    padding: 12px 20px;
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}

.contact-form button:hover {
    background-color: #218838;
}

/* Stylowanie sekcji lokalizacji */
.location-filter {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    margin: 30px auto;
    width: 80%;
    max-width: 800px;
}

.location-filter h2 {
    text-align: center;
    color: #333;
    margin-bottom: 20px;
}

/* Stylowanie dla przycisków miast */
.locations-buttons {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
}

.locations-buttons button {
    background-color: #007BFF;
    color: white;
    border: none;
    padding: 10px 20px;
    margin: 5px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease;
}

.locations-buttons button:hover {
    background-color: #0056b3;
}

/* Responsywność - na mniejszych ekranach */
@media (max-width: 768px) {
    .locations-buttons button {
        width: 100%;
        margin: 10px 0;
    }
}

</style>
