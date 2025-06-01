<?php
// panel_uzytkownika.php

session_start();
include '../includes/db.php';
include '../includes/header.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: ../pages/login.php");
    exit();
}

$page = $_GET['page'] ?? 'moje_dane';
$allowed_pages = ['moje_dane', 'moje_rezerwacje', 'ustawienia_konta'];
if (!in_array($page, $allowed_pages)) {
    $page = 'moje_dane';
}

$errors = [];
$success = '';

// Pobierz dane użytkownika
$stmt = $pdo->prepare("SELECT imie, nazwisko, telefon, email FROM uzytkownicy WHERE id_user = :id_user");
$stmt->execute(['id_user' => $_SESSION['id_user']]);
$userData = $stmt->fetch(PDO::FETCH_ASSOC);

// Obsługa aktualizacji danych
if ($page === 'ustawienia_konta' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $imie = trim($_POST['imie'] ?? '');
    $nazwisko = trim($_POST['nazwisko'] ?? '');
    $telefon = trim($_POST['telefon'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if (empty($imie)) $errors[] = 'Imię jest wymagane.';
    if (empty($nazwisko)) $errors[] = 'Nazwisko jest wymagane.';
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Poprawny email jest wymagany.';

    $stmt2 = $pdo->prepare("SELECT haslo FROM uzytkownicy WHERE id_user = :id_user");
    $stmt2->execute(['id_user' => $_SESSION['id_user']]);
    $userPass = $stmt2->fetch(PDO::FETCH_ASSOC);

    $stare_haslo = $_POST['stare_haslo'] ?? '';
    $nowe_haslo1 = $_POST['nowe_haslo1'] ?? '';
    $nowe_haslo2 = $_POST['nowe_haslo2'] ?? '';
    $change_password = false;

    if ($stare_haslo || $nowe_haslo1 || $nowe_haslo2) {
        if (!$stare_haslo || !password_verify($stare_haslo, $userPass['haslo'])) {
            $errors[] = 'Nieprawidłowe stare hasło.';
        }
        if ($nowe_haslo1 !== $nowe_haslo2) {
            $errors[] = 'Nowe hasła nie są takie same.';
        }
        if (empty($errors)) {
            $change_password = true;
        }
    }

    if (empty($errors)) {
        try {
            $pdo->beginTransaction();
            $sql = "UPDATE uzytkownicy SET imie = :imie, nazwisko = :nazwisko, telefon = :telefon, email = :email";
            if ($change_password) {
                $sql .= ", haslo = :haslo";
            }
            $sql .= " WHERE id_user = :id_user";

            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':imie', $imie);
            $stmt->bindValue(':nazwisko', $nazwisko);
            $stmt->bindValue(':telefon', $telefon);
            $stmt->bindValue(':email', $email);
            if ($change_password) {
                $stmt->bindValue(':haslo', password_hash($nowe_haslo1, PASSWORD_DEFAULT));
            }
            $stmt->bindValue(':id_user', $_SESSION['id_user'], PDO::PARAM_INT);
            $stmt->execute();
            $pdo->commit();

            $success = 'Dane zostały zaktualizowane.';
            $userData = compact('imie', 'nazwisko', 'telefon', 'email');
        } catch (Exception $e) {
            $pdo->rollBack();
            $errors[] = 'Błąd zapisu danych.';
        }
    }
}
?>

<link rel="stylesheet" href="../styles/ustawienia.css">

<main class="main-content">
  <section class="section">
    <h2>Panel użytkownika</h2>
    <nav class="sub-nav">
        <a href="?page=moje_dane" class="<?= $page === 'moje_dane' ? 'active' : '' ?>">Moje dane</a>
        <a href="?page=moje_rezerwacje" class="<?= $page === 'moje_rezerwacje' ? 'active' : '' ?>">Moje rezerwacje</a>
        <a href="?page=ustawienia_konta" class="<?= $page === 'ustawienia_konta' ? 'active' : '' ?>">Ustawienia konta</a>
    </nav>

    <div class="panel-content">

        <?php if ($page === 'moje_dane'): ?>
            <p><strong>Imię:</strong> <?= htmlspecialchars($userData['imie']) ?></p>
            <p><strong>Nazwisko:</strong> <?= htmlspecialchars($userData['nazwisko']) ?></p>
            <p><strong>Telefon:</strong> <?= htmlspecialchars($userData['telefon']) ?: '-' ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($userData['email']) ?></p>

        <?php elseif ($page === 'moje_rezerwacje'): ?>
            <?php
            // Pobranie rezerwacji użytkownika
            $stmt = $pdo->prepare("
                SELECT 
                    r.id_rezerwacji, 
                    r.data_rezerwacji, 
                    r.status, 
                    r.wielkosc_zaliczki,
                    p.id_pojazdu, 
                    p.marka, 
                    p.model, 
                    p.rok_produkcji
                FROM rezerwacje r
                JOIN pojazdy p ON r.id_pojazdu = p.id_pojazdu
                WHERE r.id_user = :id_user
                ORDER BY r.data_rezerwacji DESC
            ");
            $stmt->execute(['id_user' => $_SESSION['id_user']]);
            $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>

            <div class="my-reservations-container">
                <h3>Moje rezerwacje</h3>

                <?php if (empty($reservations)): ?>
                    <p>Nie masz żadnych rezerwacji.</p>
                <?php else: ?>
                    <table class="reservations-table">
                        <thead>
                            <tr>
                                <th>Data rezerwacji</th>
                                <th>Pojazd</th>
                                <th>Rok produkcji</th>
                                <th>Status</th>
                                <th>Wielkość zaliczki</th>
                                <th>Akcje</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reservations as $res): ?>
                                <tr class="clickable-row" data-href="szczegoly.php?id=<?= (int)$res['id_pojazdu'] ?>">
                                    <td>
                                        <?= htmlspecialchars(date('d.m.Y', strtotime($res['data_rezerwacji']))) ?>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($res['marka'] . ' ' . $res['model']) ?>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($res['rok_produkcji']) ?>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($res['status']) ?>
                                    </td>
                                    <td>
                                        <?= number_format($res['wielkosc_zaliczki'], 2, ',', ' ') ?> PLN
                                    </td>
                                    <td>
                                        <?php if ($res['status'] === 'Oczekująca'): ?>
                                            <form method="post" action="../actions/anuluj_rezerwacje.php" style="display:inline;" onclick="event.stopPropagation();">
                                                <input type="hidden" name="id_rezerwacji" value="<?= (int)$res['id_rezerwacji'] ?>">
                                                <button type="submit" class="btn-cancel"
                                                    onclick="return confirm('Czy na pewno chcesz anulować tę rezerwację?');">
                                                    Anuluj
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
                <?php endif; ?>
            </div>

        <?php elseif ($page === 'ustawienia_konta'): ?>
            <?php if ($errors): ?>
                <div class="errors"><?= implode('<br>', array_map('htmlspecialchars', $errors)) ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>

            <form method="post" class="settings-form">
                <label>Imię</label>
                <input type="text" name="imie" value="<?= htmlspecialchars($userData['imie']) ?>" required>

                <label>Nazwisko</label>
                <input type="text" name="nazwisko" value="<?= htmlspecialchars($userData['nazwisko']) ?>" required>

                <label>Telefon</label>
                <input type="tel" name="telefon" value="<?= htmlspecialchars($userData['telefon']) ?>">

                <label>Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($userData['email']) ?>" required>

                <hr>
                <small>Zmiana hasła (opcjonalnie)</small>

                <label>Stare hasło</label>
                <input type="password" name="stare_haslo">

                <label>Nowe hasło</label>
                <input type="password" name="nowe_haslo1">

                <label>Powtórz nowe hasło</label>
                <input type="password" name="nowe_haslo2">

                <button type="submit">Zapisz zmiany</button>
            </form>
        <?php endif; ?>
    </div>
  </section>
</main>

<?php include '../includes/footer.php'; ?>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".clickable-row").forEach(function (row) {
            row.addEventListener("click", function () {
                const href = this.getAttribute("data-href");
                if (href) {
                    window.location.href = href;
                }
            });
        });
    });
</script>
