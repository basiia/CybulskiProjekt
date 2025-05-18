<?php
include '../includes/db.php';

// 1. Pobranie list do formularza
$stmt_marki   = $pdo->query("SELECT DISTINCT marka FROM Pojazdy");
$stmt_paliwa  = $pdo->query("SELECT DISTINCT rodzaj_paliwa FROM Pojazdy");
$stmt_rocznik = $pdo->query("SELECT DISTINCT rok_produkcji FROM Pojazdy ORDER BY rok_produkcji DESC");
$stmt_lokacje = $pdo->query("SELECT id_lokacji, nazwa FROM Lokacje");

// 2. Inicjalizacja zmiennych z GET
$marka      = $_GET['marka'] ?? '';
$model      = $_GET['model']  ?? '';
$rocznik_od = $_GET['rocznik_od'] ?? '';
$rocznik_do = $_GET['rocznik_do'] ?? '';
$paliwo     = $_GET['paliwo'] ?? '';
$id_lokacji = isset($_GET['id_lokacji']) && is_numeric($_GET['id_lokacji'])
               ? (int) $_GET['id_lokacji'] : '';

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
});
</script>

<?php include '../includes/footer.php'; ?>
