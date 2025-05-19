<?php
include '../includes/db.php';

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
$rocznik_od = $_GET['rocznik_od'] ?? '';
$rocznik_do = $_GET['rocznik_do'] ?? '';
$paliwo = $_GET['paliwo'] ?? '';

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
});
</script>

<?php include '../includes/footer.php'; ?>
