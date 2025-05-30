<?php
include '../includes/db.php';
include '../includes/header.php';

if (!isset($_SESSION['id_user']) || !in_array($_SESSION['rola'], ['Admin', 'Pracownik'])) {
    echo "<p style='color: red; padding: 20px;'>Dostęp tylko dla pracowników lub administratorów.</p>";
    include '../includes/footer.php';
    exit;
}

// Definiujemy aktualną stronę dla podświetlenia menu
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<style>
    /* Nawigacja */
    nav.admin-nav {
        background-color: #007bff;
        padding: 10px 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        display: flex;
        gap: 20px;
        font-family: Arial, sans-serif;
    }
    nav.admin-nav a {
        color: white;
        text-decoration: none;
        font-weight: 600;
        padding: 8px 15px;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }
    nav.admin-nav a:hover {
        background-color: #0056b3;
    }
    nav.admin-nav a.active {
        background-color: #004085;
        box-shadow: 0 2px 8px rgba(0,0,0,0.3);
    }
</style>

<nav class="admin-nav">
    <a href="admin_panel.php" class="<?= $currentPage === 'admin_panel.php' ? 'active' : '' ?>">Rezerwacje</a>
    <a href="ustawienia.php" class="<?= $currentPage === 'ustawienia.php' ? 'active' : '' ?>">Ustawienia konta</a>
</nav>

<?php
// Obsługa aktualizacji rezerwacji
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_id'])) {
    $id = (int)$_POST['update_id'];
    $status = $_POST['status'];
    $data_waznosci = $_POST['data_waznosci'];
    $stmt = $pdo->prepare("UPDATE rezerwacje SET status = :status, data_waznosci = :data_waznosci WHERE id_rezerwacji = :id");
    $stmt->execute([
        ':status'       => $status,
        ':data_waznosci'=> $data_waznosci,
        ':id'           => $id
    ]);
    echo "<p class='success'>Rezerwacja #{$id} zaktualizowana.</p>";
}

// Odczyt filtrów i sortowania z GET
$filter_id = isset($_GET['id']) ? (int)$_GET['id'] : null;

// Domyślny kierunek sortowania (malejąco)
$sort_order = 'desc';

// Jeśli w URL jest sort (asc lub desc) to używamy tego
if (isset($_GET['sort']) && in_array(strtolower($_GET['sort']), ['asc', 'desc'])) {
    $sort_order = strtolower($_GET['sort']);
}

// Przygotowanie zapytania z filtrem i sortowaniem
if ($filter_id) {
    $stmt = $pdo->prepare("SELECT r.*, p.marka, p.model, u.imie, u.nazwisko
        FROM rezerwacje r
        JOIN pojazdy p ON r.id_pojazdu = p.id_pojazdu
        JOIN uzytkownicy u ON r.id_user = u.id_user
        WHERE r.id_rezerwacji = :id
        ORDER BY r.id_rezerwacji $sort_order");
    $stmt->execute([':id' => $filter_id]);
} else {
    $stmt = $pdo->query("SELECT r.*, p.marka, p.model, u.imie, u.nazwisko
        FROM rezerwacje r
        JOIN pojazdy p ON r.id_pojazdu = p.id_pojazdu
        JOIN uzytkownicy u ON r.id_user = u.id_user
        ORDER BY r.id_rezerwacji $sort_order");
}
$rezerwacje = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Funkcja do generowania linku sortowania
function sort_link($current_order, $column, $filter_id) {
    $new_order = ($current_order === 'asc') ? 'desc' : 'asc';
    $url = "?sort=$new_order";
    if ($filter_id) {
        $url .= "&id=$filter_id";
    }
    return $url;
}
?>

<style>
    body { font-family: Arial, sans-serif; background: #f9f9f9; color: #333; padding: 20px; }
    h1 { margin-bottom: 10px; }
    .success { background: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 20px; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; background: white; }
    th, td { padding: 12px; border: 1px solid #ddd; text-align: center; cursor: default; }
    th { background: #007bff; color: white; }
    th.sortable { cursor: pointer; }
    form.inline { display: flex; gap: 8px; justify-content: center; align-items: center; }
    select, input[type="date"], input[type="number"] { padding: 4px 6px; border-radius: 4px; border: 1px solid #ccc; }
    button { padding: 6px 12px; border: none; border-radius: 4px; cursor: pointer; }
    .btn-save { background: #28a745; color: white; }
    .btn-save:hover { background: #218838; }
    .logout { display: inline-block; margin-top: 10px; text-decoration: none; color: #007bff; }
    .logout:hover { text-decoration: underline; }
    th.sortable:hover { background-color: #0056b3; }
</style>

<h1>Panel pracownika / administratora</h1>

<form method="get" style="margin: 10px 0; display: flex; gap: 10px; align-items: center;">
    <label for="id">Filtruj po ID rezerwacji:</label>
    <input type="number" name="id" id="id" value="<?= $filter_id ?? '' ?>">
    <button type="submit" class="btn-save">Szukaj</button>
    <?php if ($filter_id !== null || isset($_GET['sort'])): ?>
        <a href="?" style="text-decoration: none; color: #dc3545; margin-left: 10px;">Wyczyść filtr i sortowanie</a>
    <?php endif; ?>
</form>

<?php if (count($rezerwacje) === 0): ?>
    <p>Brak rezerwacji w systemie.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th class="sortable">
                    <a href="<?= sort_link($sort_order, 'id_rezerwacji', $filter_id) ?>" style="color: white; text-decoration: none;">
                        ID
                        <?php if ($sort_order === 'asc'): ?>
                            &#9650;
                        <?php else: ?>
                            &#9660;
                        <?php endif; ?>
                    </a>
                </th>
                <th>Pojazd</th>
                <th>Użytkownik</th>
                <th>Data rezerwacji</th>
                <th>Status</th>
                <th>Zaliczka</th>
                <th>Data ważności</th>
                <th>Akcja</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rezerwacje as $r): ?>
            <tr>
                <td><?=$r['id_rezerwacji']?></td>
                <td>
                    <a href="szczegoly.php?id=<?=$r['id_pojazdu']?>" style="color:#007bff; text-decoration:none;">
                        <?=htmlspecialchars($r['marka'].' '.$r['model'])?>
                    </a>
                </td>
                <td><?=htmlspecialchars($r['imie'].' '.$r['nazwisko'])?></td>
                <td><?=$r['data_rezerwacji']?></td>
                <td>
                    <form class="inline" method="post">
                        <input type="hidden" name="update_id" value="<?=$r['id_rezerwacji']?>">
                        <select name="status">
                            <?php foreach (['Oczekująca','Zatwierdzona','Anulowana'] as $s): ?>
                                <option value="<?=$s?>" <?=$s === $r['status'] ? 'selected' : ''?>><?=$s?></option>
                            <?php endforeach; ?>
                        </select>
                </td>
                <td><?=number_format($r['wielkosc_zaliczki'],2,',','.')?> PLN</td>
                <td>
                        <input type="date" name="data_waznosci" value="<?=$r['data_waznosci']?>">
                </td>
                <td>
                        <button type="submit" class="btn-save">Zapisz</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>
