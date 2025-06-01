<?php
session_start();
include '../includes/db.php';
include '../includes/header.php';

if (!isset($_SESSION['id_user']) || !in_array($_SESSION['rola'], ['Admin', 'Pracownik'])) {
    echo "<p style='color: red; padding: 20px;'>Dostęp tylko dla pracowników lub administratorów.</p>";
    include '../includes/footer.php';
    exit;
}

$currentPage = basename($_SERVER['PHP_SELF']);
?>

<link rel="stylesheet" href="../styles/admin-styled.css">

<nav class="admin-nav">
    <a href="admin_panel.php" class="<?= $currentPage === 'admin_panel.php' ? 'active' : '' ?>">Rezerwacje</a>
    <a href="ustawienia.php" class="<?= $currentPage === 'ustawienia.php' ? 'active' : '' ?>">Ustawienia konta</a>
</nav>

<?php
// Obsługa aktualizacji
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_id'])) {
    $id = (int)$_POST['update_id'];
    $status = $_POST['status'];
    $data_waznosci = $_POST['data_waznosci'];
    $stmt = $pdo->prepare("UPDATE rezerwacje SET status = :status, data_waznosci = :data_waznosci WHERE id_rezerwacji = :id");
    $stmt->execute([
        ':status' => $status,
        ':data_waznosci' => $data_waznosci,
        ':id' => $id
    ]);
    echo "<p class='success'>Rezerwacja #{$id} zaktualizowana.</p>";
}

$filter_id = isset($_GET['id']) ? (int)$_GET['id'] : null;
$sort_order = isset($_GET['sort']) && in_array($_GET['sort'], ['asc', 'desc']) ? $_GET['sort'] : 'desc';

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

function sort_link($current_order, $column, $filter_id) {
    $new_order = $current_order === 'asc' ? 'desc' : 'asc';
    $url = "?sort=$new_order";
    if ($filter_id) $url .= "&id=$filter_id";
    return $url;
}
?>

<h1>Panel pracownika / administratora</h1>

<form method="get" class="filter-form">
    <label for="id">Filtruj po ID rezerwacji:</label>
    <input type="number" name="id" id="id" value="<?= $filter_id ?? '' ?>">
    <button type="submit" class="btn-save">Szukaj</button>
    <?php if ($filter_id !== null || isset($_GET['sort'])): ?>
        <a href="?" class="clear-filter">Wyczyść filtr i sortowanie</a>
    <?php endif; ?>
</form>

<?php if (empty($rezerwacje)): ?>
    <p>Brak rezerwacji w systemie.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th><a href="<?= sort_link($sort_order, 'id_rezerwacji', $filter_id) ?>">ID <?= $sort_order === 'asc' ? '▲' : '▼' ?></a></th>
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
                <td><?= $r['id_rezerwacji'] ?></td>
                <td><a href="szczegoly.php?id=<?= $r['id_pojazdu'] ?>"><?= htmlspecialchars($r['marka'] . ' ' . $r['model']) ?></a></td>
                <td><?= htmlspecialchars($r['imie'] . ' ' . $r['nazwisko']) ?></td>
                <td><?= $r['data_rezerwacji'] ?></td>
                <td>
                    <form class="inline" method="post">
                        <input type="hidden" name="update_id" value="<?= $r['id_rezerwacji'] ?>">
                        <select name="status">
                            <?php foreach (['Oczekująca', 'Zatwierdzona', 'Anulowana'] as $s): ?>
                                <option value="<?= $s ?>" <?= $s === $r['status'] ? 'selected' : '' ?>><?= $s ?></option>
                            <?php endforeach; ?>
                        </select>
                </td>
                <td><?= number_format($r['wielkosc_zaliczki'], 2, ',', '.') ?> PLN</td>
                <td><input type="date" name="data_waznosci" value="<?= $r['data_waznosci'] ?>"></td>
                <td><button type="submit" class="btn-save">Zapisz</button></form></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>
