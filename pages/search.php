<?php
include '../includes/db.php';
include '../includes/header.php';

function getDistinct(PDO $pdo, string $column) {
    $stmt = $pdo->prepare("SELECT DISTINCT $column FROM Pojazdy WHERE $column IS NOT NULL AND $column != '' ORDER BY $column");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

$marki    = getDistinct($pdo, 'marka');
$roczniki = getDistinct($pdo, 'rok_produkcji');
$paliwa   = getDistinct($pdo, 'rodzaj_paliwa');
$lokacje  = $pdo->query("SELECT id_lokacji, miasto FROM Lokacje ORDER BY miasto")->fetchAll(PDO::FETCH_ASSOC);

$marka      = $_GET['marka'] ?? '';
$model      = $_GET['model'] ?? '';
$rocznik_od = $_GET['rocznik_od'] ?? '';
$rocznik_do = $_GET['rocznik_do'] ?? '';
$paliwo     = $_GET['paliwo'] ?? '';
$lokacja    = $_GET['id_lokacji'] ?? '';
$page       = max(1, (int)($_GET['page'] ?? 1));
$limit      = 9;
$offset     = ($page - 1) * $limit;

$where = ["status = 'Dostępny'"];
$params = [];

if ($marka)      { $where[] = "marka = :marka"; $params[':marka'] = $marka; }
if ($model)      { $where[] = "model = :model"; $params[':model'] = $model; }
if ($rocznik_od) { $where[] = "rok_produkcji >= :rocznik_od"; $params[':rocznik_od'] = $rocznik_od; }
if ($rocznik_do) { $where[] = "rok_produkcji <= :rocznik_do"; $params[':rocznik_do'] = $rocznik_do; }
if ($paliwo)     { $where[] = "rodzaj_paliwa = :paliwo"; $params[':paliwo'] = $paliwo; }
if ($lokacja)    { $where[] = "id_lokacji = :lokacja"; $params[':lokacja'] = $lokacja; }

$where_sql = implode(' AND ', $where);
$count_sql = "SELECT COUNT(*) FROM Pojazdy WHERE $where_sql";
$stmt = $pdo->prepare($count_sql);
foreach ($params as $k => $v) $stmt->bindValue($k, $v);
$stmt->execute();
$total_rows = $stmt->fetchColumn();
$total_pages = ceil($total_rows / $limit);

$sql = "SELECT * FROM Pojazdy WHERE $where_sql ORDER BY cena ASC LIMIT :limit OFFSET :offset";
$stmt = $pdo->prepare($sql);
foreach ($params as $k => $v) $stmt->bindValue($k, $v);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$auta = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<link rel="stylesheet" href="../styles/search-styled.css">

<section class="search-wrapper">
    <form method="GET" class="search-form">
        <select name="marka" id="marka" onchange="this.form.submit()">
            <option value="">-- Wybierz markę --</option>
            <?php foreach ($marki as $m): ?>
                <option value="<?= htmlspecialchars($m) ?>" <?= $marka === $m ? 'selected' : '' ?>><?= htmlspecialchars($m) ?></option>
            <?php endforeach; ?>
        </select>

        <select name="model" id="model">
            <option value="">-- Wybierz model --</option>
        </select>

        <select name="rocznik_od">
            <option value="">Rok od</option>
            <?php foreach ($roczniki as $r): ?>
                <option value="<?= $r ?>" <?= $r == $rocznik_od ? 'selected' : '' ?>><?= $r ?></option>
            <?php endforeach; ?>
        </select>

        <select name="rocznik_do">
            <option value="">Rok do</option>
            <?php foreach ($roczniki as $r): ?>
                <option value="<?= $r ?>" <?= $r == $rocznik_do ? 'selected' : '' ?>><?= $r ?></option>
            <?php endforeach; ?>
        </select>

        <select name="paliwo">
            <option value="">Rodzaj paliwa</option>
            <?php foreach ($paliwa as $p): ?>
                <option value="<?= $p ?>" <?= $p == $paliwo ? 'selected' : '' ?>><?= $p ?></option>
            <?php endforeach; ?>
        </select>

        <select name="id_lokacji">
            <option value="">Lokalizacja</option>
            <?php foreach ($lokacje as $lok): ?>
                <option value="<?= $lok['id_lokacji'] ?>" <?= $lok['id_lokacji'] == $lokacja ? 'selected' : '' ?>>
                    <?= htmlspecialchars($lok['miasto']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <div class="search-buttons">
            <button type="submit">Szukaj</button>
        </div>
    </form>
</section>

<section class="results-grid">
    <?php if ($auta): ?>
        <?php foreach ($auta as $auto): ?>
            <div class="car-card">
                <img src="../assets/car_place.png" alt="<?= htmlspecialchars($auto['model']) ?>">
                <h3><?= htmlspecialchars($auto['marka'] . ' ' . $auto['model']) ?></h3>
                <p class="price"><?= number_format($auto['cena'], 0, ',', ' ') ?> zł</p>
                <p><?= number_format($auto['przebieg'], 0, ',', ' ') ?> km</p>
                <p><?= htmlspecialchars($auto['rodzaj_paliwa']) ?></p>
                <a href="szczegoly.php?id=<?= $auto['id_pojazdu'] ?>" class="btn">Zobacz więcej</a>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="no-results">Brak wyników pasujących do wyszukiwania.</p>
    <?php endif; ?>
</section>

<?php if ($total_pages > 1): ?>
<div class="pagination">
    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <a href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>"
           class="<?= $i === $page ? 'active' : '' ?>">
            <?= $i ?>
        </a>
    <?php endfor; ?>
</div>
<?php endif; ?>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const markaSelect = document.querySelector('#marka');
    const modelSelect = document.querySelector('#model');

    async function loadModels(marka) {
        modelSelect.innerHTML = '<option>Ładowanie...</option>';
        if (!marka) {
            modelSelect.innerHTML = '<option value="">-- Wybierz model --</option>';
            return;
        }

        try {
            const response = await fetch(`../functions/get_models.php?marka=${encodeURIComponent(marka)}`);
            const models = await response.json();
            modelSelect.innerHTML = '<option value="">-- Wybierz model --</option>';
            models.forEach(model => {
                const opt = document.createElement('option');
                opt.value = model;
                opt.textContent = model;
                if (model === "<?= addslashes($model) ?>") opt.selected = true;
                modelSelect.appendChild(opt);
            });
        } catch (e) {
            modelSelect.innerHTML = '<option value="">Błąd ładowania</option>';
        }
    }

    if (markaSelect.value) {
        loadModels(markaSelect.value);
    }

    markaSelect.addEventListener('change', () => {
        loadModels(markaSelect.value);
    });
});
</script>

<?php include '../includes/footer.php'; ?>
