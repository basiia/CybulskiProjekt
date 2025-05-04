<?php
include '../includes/db.php';

// Pobieranie dostępnych marek i paliwa
$sql_marki = "SELECT DISTINCT marka FROM Pojazdy";
$stmt_marki = $pdo->query($sql_marki);

$sql_paliwa = "SELECT DISTINCT rodzaj_paliwa FROM Pojazdy";
$stmt_paliwa = $pdo->query($sql_paliwa);

$sql_rocznik = "SELECT DISTINCT rok_produkcji FROM Pojazdy ORDER BY rok_produkcji DESC";
$stmt_rocznik = $pdo->query($sql_rocznik);

// Inicjalizacja zmiennych
$marka = $_GET['marka'] ?? '';
$model = $_GET['model'] ?? '';
$rocznik_od = $_GET['rocznik_od'] ?? '';
$rocznik_do = $_GET['rocznik_do'] ?? '';
$paliwo = $_GET['paliwo'] ?? '';

// Paginacja
$limit = 10; // liczba wyników na stronę
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql_search = "SELECT * FROM Pojazdy WHERE status = 'Dostępny'";
    $params = [];

    if (!empty($marka)) {
        $sql_search .= " AND marka = :marka";
        $params['marka'] = $marka;
    }
    if (!empty($model)) {
        $sql_search .= " AND model = :model";
        $params['model'] = $model;
    }
    if (!empty($rocznik_od)) {
        $sql_search .= " AND rok_produkcji >= :rocznik_od";
        $params['rocznik_od'] = $rocznik_od;
    }
    if (!empty($rocznik_do)) {
        $sql_search .= " AND rok_produkcji <= :rocznik_do";
        $params['rocznik_do'] = $rocznik_do;
    }
    if (!empty($paliwo)) {
        $sql_search .= " AND rodzaj_paliwa = :paliwo";
        $params['paliwo'] = $paliwo;
    }

    $sql_search .= " LIMIT :limit OFFSET :offset";
    $stmt_search = $pdo->prepare($sql_search);

    // Bindowanie normalnych parametrów
    foreach ($params as $key => $value) {
        $stmt_search->bindValue(':' . $key, $value);
    }
    // Bindowanie limitu i offsetu jako int
    $stmt_search->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt_search->bindValue(':offset', $offset, PDO::PARAM_INT);

    $stmt_search->execute();
    $results = $stmt_search->fetchAll(PDO::FETCH_ASSOC);

    // Liczenie łącznej liczby wyników
    $sql_count = "SELECT COUNT(*) FROM Pojazdy WHERE status = 'Dostępny'";
    if (!empty($marka)) $sql_count .= " AND marka = :marka";
    if (!empty($model)) $sql_count .= " AND model = :model";
    if (!empty($rocznik_od)) $sql_count .= " AND rok_produkcji >= :rocznik_od";
    if (!empty($rocznik_do)) $sql_count .= " AND rok_produkcji <= :rocznik_do";
    if (!empty($paliwo)) $sql_count .= " AND rodzaj_paliwa = :paliwo";

    $stmt_count = $pdo->prepare($sql_count);
    foreach ($params as $key => $value) {
        $stmt_count->bindValue(':' . $key, $value);
    }
    $stmt_count->execute();
    $total_results = $stmt_count->fetchColumn();
    $total_pages = ceil($total_results / $limit);
}
?>

<!-- STYLE dodane -->
<style>
.search-bar {
    background-color: #f9f9f9;
    padding: 20px;
    margin: 20px auto;
    border-radius: 12px;
    max-width: 1200px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.search-bar form {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    align-items: center;
    justify-content: space-between;
}

.search-bar select,
.search-bar input[type="number"],
.search-bar button {
    padding: 10px 12px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 16px;
    flex: 1 1 180px;
    min-width: 150px;
}

.search-bar button {
    background-color: #007bff;
    color: white;
    border: none;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.2s ease;
}

.search-bar button:hover {
    background-color: #0056b3;
}

@media (max-width: 768px) {
    .search-bar form {
        flex-direction: column;
        align-items: stretch;
    }
}

.search-results {
    margin-top: 30px;
}

.search-results h2 {
    font-size: 24px;
    font-weight: bold;
    text-align: center;
    margin-bottom: 20px;
}

.container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-around;
    gap: 20px;
    margin-top: 20px;
}

.card {
    width: 300px;
    border: 1px solid #ddd;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.card:hover {
    transform: scale(1.05);
}

.card img {
    width: 100%;
    height: 180px;
    object-fit: cover;
}

.card .card-content {
    padding: 15px;
    text-align: center;
}

.card h2 {
    font-size: 20px;
    font-weight: bold;
    margin-bottom: 10px;
}

.card p {
    font-size: 14px;
    color: #555;
    margin-bottom: 10px;
}

.card .price {
    font-size: 18px;
    font-weight: bold;
    color: #007bff;
    margin-bottom: 15px;
}

.card a {
    display: inline-block;
    text-decoration: none;
    background-color: #007bff;
    color: white;
    padding: 8px 12px;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.card a:hover {
    background-color: #0056b3;
}
</style>

<?php include '../includes/header.php'; ?>

<!-- Wyszukiwanie -->
<div class="search-bar">
    <form action="search.php" method="get">
        <select name="marka" id="marka">
            <option value="">Wybierz markę</option>
            <?php
            while ($row = $stmt_marki->fetch(PDO::FETCH_ASSOC)) {
                $selected = ($marka === $row['marka']) ? ' selected' : '';
                echo '<option value="' . htmlspecialchars($row['marka']) . '"' . $selected . '>' . htmlspecialchars($row['marka']) . '</option>';
            }
            ?>
        </select>

        <select name="model" id="model" <?php echo !empty($marka) ? '' : 'disabled'; ?>>
            <option value="">Wybierz model</option>
        </select>

        <input type="number" name="rocznik_od" min="1970" max="<?php echo date('Y'); ?>" placeholder="Rocznik od"
               value="<?php echo htmlspecialchars($rocznik_od); ?>" />

        <input type="number" name="rocznik_do" min="1970" max="<?php echo date('Y'); ?>" placeholder="Rocznik do"
               value="<?php echo htmlspecialchars($rocznik_do); ?>" />

        <select name="paliwo" id="paliwo">
            <option value="">Wybierz paliwo</option>
            <?php
            while ($row = $stmt_paliwa->fetch(PDO::FETCH_ASSOC)) {
                $selected = ($paliwo === $row['rodzaj_paliwa']) ? ' selected' : '';
                echo '<option value="' . htmlspecialchars($row['rodzaj_paliwa']) . '"' . $selected . '>' . htmlspecialchars($row['rodzaj_paliwa']) . '</option>';
            }
            ?>
        </select>

        <button type="submit">Szukaj</button>
    </form>
</div>

<!-- Wyniki wyszukiwania -->
<div class="search-results">
    <h2>Wyniki wyszukiwania</h2>
    <div class="container">
        <?php
        if (!empty($results)) {
            foreach ($results as $row) {
                echo '<div class="card">';
                echo '<img src="../assets/car_place.png" alt="Zdjęcie pojazdu">';
                echo '<div class="card-content">';
                echo '<h2>' . htmlspecialchars($row['marka']) . ' ' . htmlspecialchars($row['model']) . '</h2>';
                echo '<p>Rok produkcji: ' . htmlspecialchars($row['rok_produkcji']) . '</p>';
                echo '<p>Przebieg: ' . number_format($row['przebieg'], 0, ',', '.') . ' km</p>';
                echo '<p>Rodzaj paliwa: ' . htmlspecialchars($row['rodzaj_paliwa']) . '</p>';
                echo '<p class="price">' . number_format($row['cena'], 2, ',', '.') . ' PLN</p>';
                echo '<a href="szczegoly.php?id=' . $row['id_pojazdu'] . '">Zobacz szczegóły</a>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo "<p>Brak wyników wyszukiwania.</p>";
        }
        ?>
    </div>

    <!-- Paginacja -->
    <?php if ($total_pages > 1): ?>
    <div style="text-align:center; margin-top: 30px;">
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <?php
            // Zachowanie istniejących parametrów GET
            $query_params = $_GET;
            $query_params['page'] = $i;
            $query_string = http_build_query($query_params);
            ?>
            <a href="?<?php echo htmlspecialchars($query_string); ?>" style="margin: 0 5px; padding: 8px 12px; background-color: <?php echo $i == $page ? '#007bff' : '#eee'; ?>; color: <?php echo $i == $page ? 'white' : '#333'; ?>; text-decoration: none; border-radius: 5px;">
                <?php echo $i; ?>
            </a>
        <?php endfor; ?>
    </div>
    <?php endif; ?>
</div>

<script>
// Ładowanie modeli na podstawie wybranej marki (po załadowaniu strony i zmianie)
function loadModels(selectedMarka, selectedModel = '') {
    var modelSelect = document.getElementById('model');
    modelSelect.innerHTML = '<option value="">Wybierz model</option>';
    modelSelect.disabled = true;

    if (selectedMarka) {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "../functions/get_models.php?marka=" + encodeURIComponent(selectedMarka), true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                var models = JSON.parse(xhr.responseText);
                models.forEach(function (model) {
                    var option = document.createElement('option');
                    option.value = model;
                    option.textContent = model;
                    if (model === selectedModel) {
                        option.selected = true;
                    }
                    modelSelect.appendChild(option);
                });
                modelSelect.disabled = false;
            }
        };
        xhr.send();
    }
}

document.getElementById('marka').addEventListener('change', function () {
    loadModels(this.value);
});

// Automatyczne załadowanie modeli przy odświeżeniu (jeśli marka została wybrana)
window.addEventListener('DOMContentLoaded', function () {
    var currentMarka = "<?php echo isset($marka) ? addslashes($marka) : ''; ?>";
    var currentModel = "<?php echo isset($model) ? addslashes($model) : ''; ?>";
    if (currentMarka) {
        loadModels(currentMarka, currentModel);
    }
});
</script>

<?php include '../includes/footer.php'; ?>
