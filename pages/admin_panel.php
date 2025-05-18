<?php
include '../includes/db.php';
include '../includes/header.php';

if (!isset($_SESSION['id_user']) || !in_array($_SESSION['rola'], ['Admin', 'Pracownik'])) {
    echo "<p style='color: red; padding: 20px;'>Dostęp tylko dla pracowników lub administratorów.</p>";
    include '../includes/footer.php';
    exit;
}

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

// Obsługa filtrowania po ID
$filter_id = isset($_GET['id']) ? (int)$_GET['id'] : null;

if ($filter_id) {
    $stmt = $pdo->prepare("SELECT r.*, p.marka, p.model, u.imie, u.nazwisko
        FROM rezerwacje r
        JOIN pojazdy p ON r.id_pojazdu = p.id_pojazdu
        JOIN uzytkownicy u ON r.id_user = u.id_user
        WHERE r.id_rezerwacji = :id
        ORDER BY r.data_rezerwacji DESC");
    $stmt->execute([':id' => $filter_id]);
} else {
    $stmt = $pdo->query("SELECT r.*, p.marka, p.model, u.imie, u.nazwisko
        FROM rezerwacje r
        JOIN pojazdy p ON r.id_pojazdu = p.id_pojazdu
        JOIN uzytkownicy u ON r.id_user = u.id_user
        ORDER BY r.data_rezerwacji DESC");
}
$rezerwacje = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<style>
    body { font-family: Arial, sans-serif; background: #f9f9f9; color: #333; padding: 20px; }
    h1 { margin-bottom: 10px; }
    .success { background: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 20px; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; background: white; }
    th, td { padding: 12px; border: 1px solid #ddd; text-align: center; }
    th { background: #007bff; color: white; }
    form.inline { display: flex; gap: 8px; justify-content: center; align-items: center; }
    select, input[type="date"], input[type="number"] { padding: 4px 6px; border-radius: 4px; border: 1px solid #ccc; }
    button { padding: 6px 12px; border: none; border-radius: 4px; cursor: pointer; }
    .btn-save { background: #28a745; color: white; }
    .btn-save:hover { background: #218838; }
    .logout { display: inline-block; margin-top: 10px; text-decoration: none; color: #007bff; }
    .logout:hover { text-decoration: underline; }
</style>

<h1>Panel pracownika / administratora</h1>

<form method="get" style="margin: 10px 0; display: flex; gap: 10px; align-items: center;">
    <label for="id">Filtruj po ID rezerwacji:</label>
    <input type="number" name="id" id="id" value="<?= isset($_GET['id']) ? (int)$_GET['id'] : '' ?>">
    <button type="submit" class="btn-save">Szukaj</button>
    <?php if (isset($_GET['id'])): ?>
        <a href="?" style="text-decoration: none; color: #dc3545; margin-left: 10px;">Wyczyść filtr</a>
    <?php endif; ?>
</form>

<?php if (count($rezerwacje) === 0): ?>
    <p>Brak rezerwacji w systemie.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
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
