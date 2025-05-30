<?php
include '../includes/db.php';

// Pobierz unikalne wartości dla filtrów z bazy
function getDistinctValues(PDO $pdo, string $column) {
    $stmt = $pdo->prepare("SELECT DISTINCT $column FROM Pojazdy WHERE $column IS NOT NULL AND $column != '' ORDER BY $column ASC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

// Dla liczb (moc i liczba drzwi) pobierz min i max
function getMinMax(PDO $pdo, string $column) {
    $stmt = $pdo->prepare("SELECT MIN($column), MAX($column) FROM Pojazdy WHERE $column IS NOT NULL");
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_NUM);
}

// 1. Pobierz listy do formularza
$stmt_marki   = $pdo->query("SELECT DISTINCT marka FROM Pojazdy ORDER BY marka");
$stmt_paliwa  = $pdo->query("SELECT DISTINCT rodzaj_paliwa FROM Pojazdy ORDER BY rodzaj_paliwa");
$stmt_rocznik = $pdo->query("SELECT DISTINCT rok_produkcji FROM Pojazdy ORDER BY rok_produkcji DESC");
$stmt_lokacje = $pdo->query("SELECT id_lokacji, nazwa FROM Lokacje ORDER BY nazwa");

$kolory        = getDistinctValues($pdo, 'kolor');
$typy_pojazdu  = getDistinctValues($pdo, 'typ_pojazdu');
$napedy        = getDistinctValues($pdo, 'naped');
$rodzaje_nadwozia = getDistinctValues($pdo, 'rodzaj_nadwozia');
$kraje_pochodzenia = getDistinctValues($pdo, 'kraj_pochodzenia');

// Zakresy liczbowe
list($moc_min, $moc_max) = getMinMax($pdo, 'moc_kw');
list($drzwi_min, $drzwi_max) = getMinMax($pdo, 'liczba_drzwi');

// 2. Pobranie GET
$marka      = $_GET['marka'] ?? '';
$model      = $_GET['model'] ?? '';
$rocznik_od = $_GET['rocznik_od'] ?? '';
$rocznik_do = $_GET['rocznik_do'] ?? '';
$paliwo     = $_GET['paliwo'] ?? '';
$id_lokacji = isset($_GET['id_lokacji']) && is_numeric($_GET['id_lokacji']) ? (int)$_GET['id_lokacji'] : '';

$typ_pojazdu     = $_GET['typ_pojazdu'] ?? '';
$kolor           = $_GET['kolor'] ?? '';
$naped           = $_GET['naped'] ?? '';
$rodzaj_nadwozia = $_GET['rodzaj_nadwozia'] ?? '';
$kraj_pochodzenia = $_GET['kraj_pochodzenia'] ?? '';

$moc_od   = $_GET['moc_od'] ?? '';
$moc_do   = $_GET['moc_do'] ?? '';
$drzwi_od = $_GET['drzwi_od'] ?? '';
$drzwi_do = $_GET['drzwi_do'] ?? '';

// Paginacja
$limit = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Budowa warunków zapytania i parametrów
$params = [];
$where_clauses = ["status = 'Dostępny'"];

if ($marka)      { $where_clauses[] = "marka = :marka";            $params['marka'] = $marka; }
if ($model)      { $where_clauses[] = "model = :model";            $params['model'] = $model; }
if ($rocznik_od) { $where_clauses[] = "rok_produkcji >= :rocznik_od"; $params['rocznik_od'] = $rocznik_od; }
if ($rocznik_do) { $where_clauses[] = "rok_produkcji <= :rocznik_do"; $params['rocznik_do'] = $rocznik_do; }
if ($paliwo)     { $where_clauses[] = "rodzaj_paliwa = :paliwo";     $params['paliwo'] = $paliwo; }
if ($id_lokacji) { $where_clauses[] = "id_lokacji = :id_lokacji";     $params['id_lokacji'] = $id_lokacji; }

if ($typ_pojazdu)     { $where_clauses[] = "typ_pojazdu = :typ_pojazdu"; $params['typ_pojazdu'] = $typ_pojazdu; }
if ($kolor)           { $where_clauses[] = "kolor = :kolor";             $params['kolor'] = $kolor; }
if ($naped)           { $where_clauses[] = "naped = :naped";               $params['naped'] = $naped; }
if ($rodzaj_nadwozia) { $where_clauses[] = "rodzaj_nadwozia = :rodzaj_nadwozia"; $params['rodzaj_nadwozia'] = $rodzaj_nadwozia; }
if ($kraj_pochodzenia) { $where_clauses[] = "kraj_pochodzenia = :kraj_pochodzenia"; $params['kraj_pochodzenia'] = $kraj_pochodzenia; }

if ($moc_od !== '' && is_numeric($moc_od))   { $where_clauses[] = "moc_kw >= :moc_od"; $params['moc_od'] = $moc_od; }
if ($moc_do !== '' && is_numeric($moc_do))   { $where_clauses[] = "moc_kw <= :moc_do"; $params['moc_do'] = $moc_do; }
if ($drzwi_od !== '' && is_numeric($drzwi_od)) { $where_clauses[] = "liczba_drzwi >= :drzwi_od"; $params['drzwi_od'] = $drzwi_od; }
if ($drzwi_do !== '' && is_numeric($drzwi_do)) { $where_clauses[] = "liczba_drzwi <= :drzwi_do"; $params['drzwi_do'] = $drzwi_do; }

$where_sql = implode(' AND ', $where_clauses);

// Zapytanie z paginacją
$sql_search = "SELECT * FROM Pojazdy WHERE $where_sql LIMIT :limit OFFSET :offset";
$stmt_search = $pdo->prepare($sql_search);

foreach ($params as $key => $val) {
    $stmt_search->bindValue(":$key", $val);
}

$stmt_search->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt_search->bindValue(':offset', $offset, PDO::PARAM_INT);

$stmt_search->execute();
$results = $stmt_search->fetchAll(PDO::FETCH_ASSOC);

// Liczba wszystkich wyników
$sql_count = "SELECT COUNT(*) FROM Pojazdy WHERE $where_sql";
$stmt_count = $pdo->prepare($sql_count);
foreach ($params as $key => $val) {
    $stmt_count->bindValue(":$key", $val);
}
$stmt_count->execute();
$total_results = $stmt_count->fetchColumn();
$total_pages = ceil($total_results / $limit);

include '../includes/header.php';
?>

<style>
/* Style formularza i wyników - podobne do wcześniejszych, z dodatkiem */
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
.search-bar input[type="text"],
.search-bar button {
    padding: 10px 12px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 16px;
    flex: 1 1 160px;
    min-width: 140px;
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
#extraFilters {
    gap: 10px;
}
.search-results {
    margin-top: 30px;
}
.card {
    border: 1px solid #ddd;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 14px rgba(0,0,0,0.06);
    transition: transform 0.2s ease;
    background: white;
    width: 280px;
}
.card:hover {
    transform: scale(1.05);
}
.card img {
    width: 100%;
    height: 160px;
    object-fit: cover;
    border-bottom: 1px solid #ddd;
}
.card-body {
    padding: 12px 16px;
}
.card-body h3 {
    margin: 0 0 6px 0;
    font-size: 18px;
    font-weight: 700;
    color: #333;
}
.card-body p {
    font-size: 14px;
    color: #555;
    margin: 3px 0;
}
.pagination {
    margin: 30px 0;
    text-align: center;
}
.pagination a, .pagination span {
    margin: 0 6px;
    padding: 8px 14px;
    background: #007bff;
    color: white;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 600;
}
.pagination span {
    background: #0056b3;
    cursor: default;
}
</style>

<div class="search-bar">
    <form method="get" id="searchForm" action="">
        <select name="marka" id="marka" onchange="loadModels(this.value)">
            <option value="">-- Wybierz markę --</option>
            <?php foreach ($stmt_marki as $row): ?>
                <option value="<?=htmlspecialchars($row['marka'])?>" <?=($row['marka'] == $marka ? 'selected' : '')?>><?=htmlspecialchars($row['marka'])?></option>
            <?php endforeach; ?>
        </select>

        <select name="model" id="model">
            <option value="">-- Wybierz model --</option>
            <!-- Modele będą ładowane dynamicznie -->
        </select>

        <select name="rocznik_od">
            <option value="">Rok od</option>
            <?php foreach ($stmt_rocznik as $row): ?>
                <option value="<?=htmlspecialchars($row['rok_produkcji'])?>" <?=($row['rok_produkcji'] == $rocznik_od ? 'selected' : '')?>><?=htmlspecialchars($row['rok_produkcji'])?></option>
            <?php endforeach; ?>
        </select>

        <select name="rocznik_do">
            <option value="">Rok do</option>
            <?php foreach ($stmt_rocznik as $row): ?>
                <option value="<?=htmlspecialchars($row['rok_produkcji'])?>" <?=($row['rok_produkcji'] == $rocznik_do ? 'selected' : '')?>><?=htmlspecialchars($row['rok_produkcji'])?></option>
            <?php endforeach; ?>
        </select>

        <select name="paliwo">
            <option value="">Rodzaj paliwa</option>
            <?php foreach ($stmt_paliwa as $row): ?>
                <option value="<?=htmlspecialchars($row['rodzaj_paliwa'])?>" <?=($row['rodzaj_paliwa'] == $paliwo ? 'selected' : '')?>><?=htmlspecialchars($row['rodzaj_paliwa'])?></option>
            <?php endforeach; ?>
        </select>

        <select name="id_lokacji">
            <option value="">Lokalizacja</option>
            <?php foreach ($stmt_lokacje as $row): ?>
                <option value="<?=htmlspecialchars($row['id_lokacji'])?>" <?=($row['id_lokacji'] == $id_lokacji ? 'selected' : '')?>><?=htmlspecialchars($row['nazwa'])?></option>
            <?php endforeach; ?>
        </select>

        <button type="button" id="toggleFiltersBtn" onclick="toggleExtraFilters()">Więcej filtrów ▼</button>

        <button type="submit">Szukaj</button>

        <div id="extraFilters" style="display:none; margin-top:10px; flex-wrap: wrap;">
            <select name="typ_pojazdu">
                <option value="">Typ pojazdu</option>
                <?php foreach ($typy_pojazdu as $val): ?>
                    <option value="<?=htmlspecialchars($val)?>" <?=($val == $typ_pojazdu ? 'selected' : '')?>><?=htmlspecialchars($val)?></option>
                <?php endforeach; ?>
            </select>

            <select name="kolor">
                <option value="">Kolor</option>
                <?php foreach ($kolory as $val): ?>
                    <option value="<?=htmlspecialchars($val)?>" <?=($val == $kolor ? 'selected' : '')?>><?=htmlspecialchars($val)?></option>
                <?php endforeach; ?>
            </select>

            <select name="naped">
                <option value="">Napęd</option>
                <?php foreach ($napedy as $val): ?>
                    <option value="<?=htmlspecialchars($val)?>" <?=($val == $naped ? 'selected' : '')?>><?=htmlspecialchars($val)?></option>
                <?php endforeach; ?>
            </select>

            <select name="rodzaj_nadwozia">
                <option value="">Rodzaj nadwozia</option>
                <?php foreach ($rodzaje_nadwozia as $val): ?>
                    <option value="<?=htmlspecialchars($val)?>" <?=($val == $rodzaj_nadwozia ? 'selected' : '')?>><?=htmlspecialchars($val)?></option>
                <?php endforeach; ?>
            </select>

            <select name="kraj_pochodzenia">
                <option value="">Kraj pochodzenia</option>
                <?php foreach ($kraje_pochodzenia as $val): ?>
                    <option value="<?=htmlspecialchars($val)?>" <?=($val == $kraj_pochodzenia ? 'selected' : '')?>><?=htmlspecialchars($val)?></option>
                <?php endforeach; ?>
            </select>

            <input type="number" name="moc_od" min="<?=intval($moc_min)?>" max="<?=intval($moc_max)?>" placeholder="Moc od (kW)" value="<?=htmlspecialchars($moc_od)?>">
            <input type="number" name="moc_do" min="<?=intval($moc_min)?>" max="<?=intval($moc_max)?>" placeholder="Moc do (kW)" value="<?=htmlspecialchars($moc_do)?>">

            <input type="number" name="drzwi_od" min="<?=intval($drzwi_min)?>" max="<?=intval($drzwi_max)?>" placeholder="Drzwi od" value="<?=htmlspecialchars($drzwi_od)?>">
            <input type="number" name="drzwi_do" min="<?=intval($drzwi_min)?>" max="<?=intval($drzwi_max)?>" placeholder="Drzwi do" value="<?=htmlspecialchars($drzwi_do)?>">
        </div>
    </form>
</div>

<div class="search-results">
    <?php if (count($results) > 0): ?>
        <div style="display:flex; flex-wrap: wrap; gap: 20px; justify-content: center;">
        <?php foreach ($results as $row): ?>
            <div class="card">
                <img src="../assets/car_place.png" alt="Zdjęcie <?=htmlspecialchars($row['marka'].' '.$row['model'])?>">
                <div class="card-body">
                    <h3><?=htmlspecialchars($row['marka'].' '.$row['model'])?></h3>
                    <p>Rok: <?=htmlspecialchars($row['rok_produkcji'])?></p>
                    <p>Paliwo: <?=htmlspecialchars($row['rodzaj_paliwa'])?></p>
                    <p>Moc: <?=htmlspecialchars($row['moc_kw'])?> KW</p>
                    <p>Kolor: <?=htmlspecialchars($row['kolor'])?></p>
                    <p>Cena: <?=number_format($row['cena'], 0, ',', ' ')?> PLN</p>
                    <a href="./szczegoly.php?id=<?=htmlspecialchars($row['id_pojazdu'])?>" style="color:#007bff; font-weight:600; text-decoration:none;">Szczegóły</a>
                </div>
            </div>
        <?php endforeach; ?>
        </div>

        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?<?=http_build_query(array_merge($_GET, ['page' => $page - 1]))?>">&laquo; Poprzednia</a>
            <?php endif; ?>

            <span>Strona <?= $page ?> z <?= $total_pages ?></span>

            <?php if ($page < $total_pages): ?>
                <a href="?<?=http_build_query(array_merge($_GET, ['page' => $page + 1]))?>">Następna &raquo;</a>
            <?php endif; ?>
        </div>

    <?php else: ?>
        <p>Brak wyników wyszukiwania dla podanych kryteriów.</p>
    <?php endif; ?>
</div>

<script>
// Przełączanie dodatkowych filtrów
function toggleExtraFilters() {
    const extraFilters = document.getElementById('extraFilters');
    const btn = document.getElementById('toggleFiltersBtn');
    if (extraFilters.style.display === 'none') {
        extraFilters.style.display = 'flex';
        btn.textContent = 'Mniej filtrów ▲';
    } else {
        extraFilters.style.display = 'none';
        btn.textContent = 'Więcej filtrów ▼';
    }
}

// Ładowanie modeli na podstawie marki (AJAX)
async function loadModels(marka) {
    const modelSelect = document.getElementById('model');
    modelSelect.innerHTML = '<option>Ładowanie...</option>';
    if (!marka) {
        modelSelect.innerHTML = '<option value="">-- Wybierz model --</option>';
        return;
    }

    try {
        const response = await fetch('/ajax/get_models.php?marka=' + encodeURIComponent(marka));
        if (!response.ok) throw new Error('Błąd sieci');

        const models = await response.json();
        modelSelect.innerHTML = '<option value="">-- Wybierz model --</option>';
        for (const model of models) {
            const opt = document.createElement('option');
            opt.value = model;
            opt.textContent = model;
            // Jeśli model pasuje do aktualnego GET, zaznacz go
            if (model === '<?= addslashes($model) ?>') {
                opt.selected = true;
            }
            modelSelect.appendChild(opt);
        }
    } catch (error) {
        modelSelect.innerHTML = '<option value="">Błąd ładowania modeli</option>';
        console.error(error);
    }
}

// Załaduj modele przy ładowaniu strony jeśli marka jest już wybrana
document.addEventListener('DOMContentLoaded', () => {
    if ('<?=addslashes($marka)?>') {
        loadModels('<?=addslashes($marka)?>');
    }
});
</script>

<?php include '../includes/footer.php'; ?>
