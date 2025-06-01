<?php
session_start();
include '../includes/db.php';
include '../includes/header.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
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
