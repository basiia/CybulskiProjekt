<?php
include '../includes/db.php';

<<<<<<< HEAD
// Pobieranie unikalnych wartości do filtrów
$sql_marki = "SELECT DISTINCT marka FROM Pojazdy";
$stmt_marki = $pdo->query($sql_marki);

$sql_paliwa = "SELECT DISTINCT rodzaj_paliwa FROM Pojazdy";
$stmt_paliwa = $pdo->query($sql_paliwa);

$sql_rocznik = "SELECT DISTINCT rok_produkcji FROM Pojazdy ORDER BY rok_produkcji DESC";
$stmt_rocznik = $pdo->query($sql_rocznik);

// Pobieranie wartości z GET
$marka = $_GET['marka'] ?? '';
$model = $_GET['model'] ?? '';
=======
// 1. Pobranie list do formularza
$stmt_marki   = $pdo->query("SELECT DISTINCT marka FROM Pojazdy");
$stmt_paliwa  = $pdo->query("SELECT DISTINCT rodzaj_paliwa FROM Pojazdy");
$stmt_rocznik = $pdo->query("SELECT DISTINCT rok_produkcji FROM Pojazdy ORDER BY rok_produkcji DESC");
$stmt_lokacje = $pdo->query("SELECT id_lokacji, nazwa FROM Lokacje");

// 2. Inicjalizacja zmiennych z GET
$marka      = $_GET['marka'] ?? '';
$model      = $_GET['model']  ?? '';
>>>>>>> c9d6b7b5abbae0e6a3ed725c5ca0c1352febc04c
$rocznik_od = $_GET['rocznik_od'] ?? '';
$rocznik_do = $_GET['rocznik_do'] ?? '';
$paliwo     = $_GET['paliwo'] ?? '';
$id_lokacji = isset($_GET['id_lokacji']) && is_numeric($_GET['id_lokacji'])
               ? (int) $_GET['id_lokacji'] : '';

<<<<<<< HEAD
$limit = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Szukanie pojazdów
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

foreach ($params as $key => $value) {
    $stmt_search->bindValue(':' . $key, $value);
}
$stmt_search->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt_search->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt_search->execute();
$results = $stmt_search->fetchAll(PDO::FETCH_ASSOC);

// Liczenie wyników
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

include '../includes/header.php';
?>

<!-- Formularz filtrów -->
<section class="search-bar" style="background: #f6f6f6; padding: 40px 20px; border-radius: 12px; max-width: 1200px; margin: 40px auto;">
  <form method="get" style="display: flex; flex-wrap: wrap; gap: 16px; justify-content: center;">
    <select name="marka" id="marka" style="padding: 14px 20px; font-size: 16px; border-radius: 10px; border: 1px solid #ccc;">
      <option value="">Marka</option>
      <?php while ($row = $stmt_marki->fetch(PDO::FETCH_ASSOC)): ?>
        <option value="<?= htmlspecialchars($row['marka']) ?>" <?= $marka === $row['marka'] ? 'selected' : '' ?>>
          <?= htmlspecialchars($row['marka']) ?>
        </option>
      <?php endwhile; ?>
    </select>
=======
// 3. Paginacja
$limit  = 10;
$page   = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// 4. Budowa zapytania głównego i liczącego
$params     = [];
$where_clauses = ["status = 'Dostępny'"];

if ($marka)      { $where_clauses[] = "marka = :marka";            $params['marka']      = $marka; }
if ($model)      { $where_clauses[] = "model = :model";            $params['model']      = $model; }
if ($rocznik_od) { $where_clauses[] = "rok_produkcji >= :rocznik_od"; $params['rocznik_od'] = $rocznik_od; }
if ($rocznik_do) { $where_clauses[] = "rok_produkcji <= :rocznik_do"; $params['rocznik_do'] = $rocznik_do; }
if ($paliwo)     { $where_clauses[] = "rodzaj_paliwa = :paliwo";     $params['paliwo']     = $paliwo; }
if ($id_lokacji) { $where_clauses[] = "id_lokacji = :id_lokacji";     $params['id_lokacji'] = $id_lokacji; }

$where_sql = implode(' AND ', $where_clauses);

// 5. Zapytanie główne
$sql_search = "SELECT * FROM Pojazdy WHERE $where_sql LIMIT :limit OFFSET :offset";
$stmt_search = $pdo->prepare($sql_search);

// Bind filtrowe
foreach ($params as $key => $val) {
    $stmt_search->bindValue(":$key", $val);
}
// Bind paginacyjne
$stmt_search->bindValue(':limit',  $limit,  PDO::PARAM_INT);
$stmt_search->bindValue(':offset', $offset, PDO::PARAM_INT);

$stmt_search->execute();
$results = $stmt_search->fetchAll(PDO::FETCH_ASSOC);

// 6. Zapytanie COUNT(*)
$sql_count = "SELECT COUNT(*) FROM Pojazdy WHERE $where_sql";
$stmt_count = $pdo->prepare($sql_count);
foreach ($params as $key => $val) {
    $stmt_count->bindValue(":$key", $val);
}
$stmt_count->execute();
$total_results = $stmt_count->fetchColumn();
$total_pages   = ceil($total_results / $limit);
?>

<?php include '../includes/header.php'; ?>

<style>
.search-bar {
    background-color: #f9f9f9;
    padding: 20px;
    margin: 20px auto;
    border-radius: 12px;
    max-width: 1200px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
>>>>>>> c9d6b7b5abbae0e6a3ed725c5ca0c1352febc04c

    <select name="model" id="model" style="padding: 14px 20px; font-size: 16px; border-radius: 10px; border: 1px solid #ccc;" <?= empty($marka) ? 'disabled' : '' ?>>
      <option value="">Model</option>
    </select>

    <select name="paliwo" style="padding: 14px 20px; font-size: 16px; border-radius: 10px; border: 1px solid #ccc;">
      <option value="">Paliwo</option>
      <?php while ($row = $stmt_paliwa->fetch(PDO::FETCH_ASSOC)): ?>
        <option value="<?= htmlspecialchars($row['rodzaj_paliwa']) ?>" <?= $paliwo === $row['rodzaj_paliwa'] ? 'selected' : '' ?>>
          <?= htmlspecialchars($row['rodzaj_paliwa']) ?>
        </option>
      <?php endwhile; ?>
    </select>

    <select name="rocznik_od" style="padding: 14px 20px; font-size: 16px; border-radius: 10px; border: 1px solid #ccc;">
      <option value="">Rocznik od</option>
      <?php while ($row = $stmt_rocznik->fetch(PDO::FETCH_ASSOC)): ?>
        <option value="<?= $row['rok_produkcji'] ?>" <?= $rocznik_od == $row['rok_produkcji'] ? 'selected' : '' ?>>
          <?= $row['rok_produkcji'] ?>
        </option>
      <?php endwhile; ?>
    </select>

    <select name="rocznik_do" style="padding: 14px 20px; font-size: 16px; border-radius: 10px; border: 1px solid #ccc;">
      <option value="">Rocznik do</option>
      <?php for ($i = date('Y'); $i >= 1970; $i--): ?>
        <option value="<?= $i ?>" <?= $rocznik_do == $i ? 'selected' : '' ?>><?= $i ?></option>
      <?php endfor; ?>
    </select>

    <button type="submit" style="padding: 14px 28px; font-size: 16px; font-weight: bold; border-radius: 10px; background: #d80000; color: white; border: none; cursor: pointer;">
      Szukaj
    </button>
  </form>
</section>

<!-- Wyniki -->
<section style="padding: 60px 20px; background-color: #f6f6f6;">
  <h2 style="text-align: center; font-size: 28px; margin-bottom: 40px;">Wyniki wyszukiwania</h2>

<<<<<<< HEAD
  <div class="car-grid" style="display: flex; gap: 20px; padding: 0 20px 40px; justify-content: center; flex-wrap: wrap;">
    <?php if (!empty($results)): ?>
      <?php foreach ($results as $row): ?>
        <div class="car-card" style="background: white; border: 1px solid #eee; border-radius: 12px; padding: 20px; width: 260px; text-align: center; box-shadow: 0 0 8px rgba(0,0,0,0.03);">
          <img src="../assets/car_place.png" alt="<?= htmlspecialchars($row['marka']) ?>" style="width: 100%; height: auto; border-radius: 8px; margin-bottom: 10px;">
          <h3><?= htmlspecialchars($row['marka']) ?> <?= htmlspecialchars($row['model']) ?></h3>
          <p><strong><?= number_format($row['cena'], 0, ',', ' ') ?> zł</strong></p>
          <p><?= number_format($row['przebieg'], 0, ',', ' ') ?> km</p>
          <p><?= htmlspecialchars($row['rodzaj_paliwa']) ?></p>
          <a href="szczegoly.php?id=<?= $row['id_pojazdu'] ?>" style="display:inline-block; margin-top: 10px; padding: 10px 16px; background:#d80000; color:#fff; border-radius: 8px; font-weight:bold; text-decoration:none;">Zobacz więcej</a>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p style="text-align:center;">Brak wyników wyszukiwania.</p>
    <?php endif; ?>
  </div>

  <!-- Paginacja -->
  <?php if ($total_pages > 1): ?>
  <div style="text-align:center; margin-top: 30px;">
    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
      <?php
      $query_params = $_GET;
      $query_params['page'] = $i;
      $query_string = http_build_query($query_params);
      ?>
      <a href="?<?= htmlspecialchars($query_string) ?>"
         style="margin: 0 5px; padding: 8px 12px; background-color: <?= $i == $page ? '#d80000' : '#eee' ?>; color: <?= $i == $page ? 'white' : '#333' ?>; text-decoration: none; border-radius: 5px;">
        <?= $i ?>
      </a>
    <?php endfor; ?>
  </div>
  <?php endif; ?>
</section>

<!-- Skrypt do modeli -->
<script>
function loadModels(selectedMarka, selectedModel = '') {
  const modelSelect = document.getElementById('model');
  modelSelect.innerHTML = '<option value="">Model</option>';
  modelSelect.disabled = true;

  if (selectedMarka) {
    fetch(`../functions/get_models.php?marka=${encodeURIComponent(selectedMarka)}`)
      .then(res => res.json())
      .then(models => {
        models.forEach(model => {
          const option = document.createElement('option');
          option.value = model;
          option.textContent = model;
          if (model === selectedModel) option.selected = true;
          modelSelect.appendChild(option);
        });
        modelSelect.disabled = false;
      });
  }
}

document.getElementById('marka').addEventListener('change', e => {
  loadModels(e.target.value);
});

window.addEventListener('DOMContentLoaded', () => {
  const currentMarka = <?= json_encode($marka) ?>;
  const currentModel = <?= json_encode($model) ?>;
  if (currentMarka) {
    loadModels(currentMarka, currentModel);
  }
=======
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
.pagination {
    margin: 30px auto;
    text-align: center;
}

.pagination a {
    display: inline-block;
    margin: 0 4px;
    padding: 8px 12px;
    background-color: #eee;
    color: #333;
    text-decoration: none;
    border-radius: 6px;
    transition: background-color 0.2s;
    font-weight: bold;
}

.pagination a:hover {
    background-color: #ccc;
}

.pagination a.current {
    background-color: #007bff;
    color: white;
    pointer-events: none;
}

</style>

<div class="search-bar">
  <form action="search.php" method="get">
    <select name="marka" id="marka">
      <option value="">Wybierz markę</option>
      <?php while ($row = $stmt_marki->fetch(PDO::FETCH_ASSOC)): ?>
        <option value="<?= htmlspecialchars($row['marka']) ?>"
          <?= $row['marka'] === $marka ? 'selected' : '' ?>>
          <?= htmlspecialchars($row['marka']) ?>
        </option>
      <?php endwhile; ?>
    </select>

    <select name="model" id="model" <?= $marka ? '' : 'disabled' ?>>
      <option value="">Wybierz model</option>
    </select>

    <input type="number" name="rocznik_od" min="1970" max="<?= date('Y') ?>"
           placeholder="Rocznik od" value="<?= htmlspecialchars($rocznik_od) ?>"/>

    <input type="number" name="rocznik_do" min="1970" max="<?= date('Y') ?>"
           placeholder="Rocznik do" value="<?= htmlspecialchars($rocznik_do) ?>"/>

    <select name="paliwo">
      <option value="">Wybierz paliwo</option>
      <?php while ($row = $stmt_paliwa->fetch(PDO::FETCH_ASSOC)): ?>
        <option value="<?= htmlspecialchars($row['rodzaj_paliwa']) ?>"
          <?= $row['rodzaj_paliwa'] === $paliwo ? 'selected' : '' ?>>
          <?= htmlspecialchars($row['rodzaj_paliwa']) ?>
        </option>
      <?php endwhile; ?>
    </select>

    <select name="id_lokacji">
      <option value="">Wybierz lokalizację</option>
      <?php while ($row = $stmt_lokacje->fetch(PDO::FETCH_ASSOC)): ?>
        <option value="<?= (int)$row['id_lokacji'] ?>"
          <?= $row['id_lokacji'] == $id_lokacji ? 'selected' : '' ?>>
          <?= htmlspecialchars($row['nazwa']) ?>
        </option>
      <?php endwhile; ?>
    </select>

    <button type="submit">Szukaj</button>
  </form>
</div>

<div class="search-results">
  <h2>Wyniki wyszukiwania (<?= $total_results ?>)</h2>
  <div class="container">
    <?php if ($results): foreach ($results as $row): ?>
      <div class="card">
        <img src="../assets/car_place.png" alt="">
        <div class="card-content">
          <h2><?= htmlspecialchars($row['marka'].' '.$row['model']) ?></h2>
          <p>Rok: <?= $row['rok_produkcji'] ?> | Przebieg: <?= number_format($row['przebieg'],0,',','.') ?> km</p>
          <p class="price"><?= number_format($row['cena'],2,',','.') ?> PLN</p>
          <a href="szczegoly.php?id=<?= $row['id_pojazdu'] ?>">Zobacz szczegóły</a>
        </div>
      </div>
    <?php endforeach; else: ?>
      <p>Brak wyników</p>
    <?php endif; ?>
  </div>

 <!-- paginacja -->
  <?php if ($total_pages > 1): ?>
  <div class="pagination">
    <?php
      $range = 2; // ile stron pokazać przed i po bieżącej
      $start = max(1, $page - $range);
      $end   = min($total_pages, $page + $range);

      // poprzednia strona
      if ($page > 1) {
        $qp = $_GET; $qp['page'] = $page - 1;
        echo '<a href="?' . htmlspecialchars(http_build_query($qp)) . '">&laquo;</a>';
      }

      // strony
      for ($i = $start; $i <= $end; $i++) {
        $qp = $_GET; $qp['page'] = $i;
        $cls = $i == $page ? 'current' : '';
        echo '<a href="?' . htmlspecialchars(http_build_query($qp)) . '" class="' . $cls . '">' . $i . '</a>';
      }

      // następna strona
      if ($page < $total_pages) {
        $qp = $_GET; $qp['page'] = $page + 1;
        echo '<a href="?' . htmlspecialchars(http_build_query($qp)) . '">&raquo;</a>';
      }
    ?>
  </div>
<?php endif; ?>



<script>
// dynamiczne modele
function loadModels(marka, selected='') {
  let sel = document.getElementById('model');
  sel.innerHTML = '<option>Ładowanie…</option>';
  sel.disabled = true;
  if (!marka) return sel.disabled=true, sel.innerHTML='<option>Wybierz model</option>';
  fetch("../functions/get_models.php?marka="+encodeURIComponent(marka))
    .then(r=>r.json())
    .then(list=>{
      sel.innerHTML='<option value="">Wybierz model</option>';
      list.forEach(m=>{
        let o=new Option(m,m);
        if(m===selected) o.selected=true;
        sel.add(o);
      });
      sel.disabled=false;
    });
}
document.getElementById('marka').addEventListener('change',e=>{
  loadModels(e.target.value);
});
window.addEventListener('DOMContentLoaded',()=>{
  if("<?= addslashes($marka) ?>") loadModels("<?= addslashes($marka) ?>","<?= addslashes($model) ?>");
>>>>>>> c9d6b7b5abbae0e6a3ed725c5ca0c1352febc04c
});
</script>

<?php include '../includes/footer.php'; ?>
