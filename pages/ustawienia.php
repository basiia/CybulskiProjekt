<?php include '../includes/header.php'; ?>
<?php
include '../includes/db.php';


if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

// Wybrane podstrony (zakładki)
$page = $_GET['page'] ?? 'moje_dane';
$allowed_pages = ['moje_dane', 'moje_rezerwacje', 'ustawienia_konta'];
if (!in_array($page, $allowed_pages)) {
    $page = 'moje_dane';
}

$errors = [];
$success = '';

// Pobierz dane użytkownika na start (do wyświetlenia w Moje dane i Ustawienia konta)
$stmt = $pdo->prepare("SELECT imie, nazwisko, telefon, email FROM uzytkownicy WHERE id_user = :id_user");
$stmt->execute(['id_user' => $_SESSION['id_user']]);
$userData = $stmt->fetch(PDO::FETCH_ASSOC);

// Obsługa zapisu zmian w ustawieniach konta
if ($page === 'ustawienia_konta' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $imie = trim($_POST['imie'] ?? '');
    $nazwisko = trim($_POST['nazwisko'] ?? '');
    $telefon = trim($_POST['telefon'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if (empty($imie)) $errors[] = 'Imię jest wymagane.';
    if (empty($nazwisko)) $errors[] = 'Nazwisko jest wymagane.';
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Poprawny email jest wymagany.';

    // Pobierz aktualne hasło (do sprawdzenia przy zmianie hasła)
    $stmt2 = $pdo->prepare("SELECT haslo FROM uzytkownicy WHERE id_user = :id_user");
    $stmt2->execute(['id_user' => $_SESSION['id_user']]);
    $userPass = $stmt2->fetch(PDO::FETCH_ASSOC);

    $stare_haslo = $_POST['stare_haslo'] ?? '';
    $nowe_haslo1 = $_POST['nowe_haslo1'] ?? '';
    $nowe_haslo2 = $_POST['nowe_haslo2'] ?? '';

    $change_password = false;

    if ($stare_haslo !== '' || $nowe_haslo1 !== '' || $nowe_haslo2 !== '') {
        if (!$stare_haslo) {
            $errors[] = 'Podaj stare hasło, aby zmienić hasło.';
        } elseif (!password_verify($stare_haslo, $userPass['haslo'])) {
            $errors[] = 'Stare hasło jest niepoprawne.';
        }

        if (!$nowe_haslo1 || !$nowe_haslo2) {
            $errors[] = 'Podaj nowe hasło dwukrotnie.';
        } elseif ($nowe_haslo1 !== $nowe_haslo2) {
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

            $success = 'Dane zostały zaktualizowane pomyślnie.';

            // Aktualizuj dane do wyświetlenia po zmianie
            $userData['imie'] = $imie;
            $userData['nazwisko'] = $nazwisko;
            $userData['telefon'] = $telefon;
            $userData['email'] = $email;
        } catch (Exception $e) {
            $pdo->rollBack();
            $errors[] = 'Wystąpił błąd podczas aktualizacji danych: ' . $e->getMessage();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8" />
    <title>Ustawienia użytkownika - Karpol</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .container {
            display: flex;
            max-width: 1200px;
            margin: 40px auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 10px #ccc;
            min-height: 500px;
        }
        nav {
            width: 220px;
            background: #333;
            color: white;
            display: flex;
            flex-direction: column;
            padding: 20px;
            border-radius: 8px 0 0 8px;
        }
        nav a {
            color: white;
            text-decoration: none;
            padding: 12px 15px;
            margin-bottom: 10px;
            border-radius: 4px;
        }
        nav a.active, nav a:hover {
            background: #d80000;
        }
        nav a.logout {
            margin-top: auto;
            background: #666;
            cursor: pointer;
            text-align: center;
        }
        main {
            flex-grow: 1;
            padding: 30px;
        }
        h2 {
            margin-bottom: 20px;
        }
        .errors {
            background: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
        }
        .success {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
        }
        form label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }
        form input[type=text], form input[type=email], form input[type=tel], form input[type=password] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 4px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        form button {
            margin-top: 25px;
            background: #d80000;
            color: white;
            border: none;
            padding: 12px 25px;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
        }
        small {
            color: #666;
        }
        /* Style kafelków w Moje rezerwacje */
        .reservation-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .reservation-tile {
            border: 1px solid #ccc;
            border-radius: 8px;
            width: 280px;
            padding: 15px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            background: white;
        }
        .reservation-tile img {
            width: 100%;
            height: 160px;
            object-fit: cover;
            border-radius: 6px;
        }
        .no-image {
            width: 100%;
            height: 160px;
            background: #eee;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            color: #999;
        }
        .details-button {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 15px;
            background-color: #d80000;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            font-size: 0.9em;
        }
    </style>
</head>
<body>

<div class="container">
    <nav>
        <a href="?page=moje_dane" class="<?= $page === 'moje_dane' ? 'active' : '' ?>">Moje dane</a>
        <a href="?page=moje_rezerwacje" class="<?= $page === 'moje_rezerwacje' ? 'active' : '' ?>">Moje rezerwacje</a>
        <a href="?page=ustawienia_konta" class="<?= $page === 'ustawienia_konta' ? 'active' : '' ?>">Ustawienia konta</a>
    </nav>

    <main>
        <?php if ($page === 'moje_dane'): ?>
            <h2>Moje dane</h2>
            <p><strong>Imię:</strong> <?= htmlspecialchars($userData['imie']) ?></p>
            <p><strong>Nazwisko:</strong> <?= htmlspecialchars($userData['nazwisko']) ?></p>
            <p><strong>Telefon:</strong> <?= htmlspecialchars($userData['telefon']) ?: '-' ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($userData['email']) ?></p>

        <?php elseif ($page === 'moje_rezerwacje'): ?>
            <h2>Moje rezerwacje</h2>
            <div class="reservation-list">
            <?php
            // Pobierz rezerwacje wraz z danymi pojazdu (dostosuj nazwy pól i tabel do swojej bazy)
            $stmt = $pdo->prepare("
                SELECT r.id_rezerwacji, r.data_rezerwacji, r.status, r.wielkosc_zaliczki,
                       p.id_pojazdu, p.marka, p.model, p.rok_produkcji
                FROM rezerwacje r
                JOIN pojazdy p ON r.id_pojazdu = p.id_pojazdu
                WHERE r.id_user = :id_user
                ORDER BY r.data_rezerwacji DESC
            ");
            $stmt->execute(['id_user' => $_SESSION['id_user']]);
            $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (!$reservations) {
                echo "<p>Nie masz jeszcze żadnych rezerwacji.</p>";
            } else {
                foreach ($reservations as $res) {
                    ?>
                    <div class="reservation-tile">
                        <img src="../assets/car_place.png" alt="Zdjęcie pojazdu">
                        <h3 style="margin: 10px 0 5px; font-size: 1.1em;">
                            <?= htmlspecialchars($res['marka']) . ' ' . htmlspecialchars($res['model']) ?> (<?= htmlspecialchars($res['rok_produkcji']) ?>)
                        </h3>
                        <p style="margin: 0; font-size: 0.9em; font-weight: bold; color: #d80000;">
                            Wartość zaliczki: <?= number_format($res['wielkosc_zaliczki'], 2, ',', ' ') ?> zł
                        </p>
                        <p style="margin: 0; font-size: 0.9em;">
                            <strong>Data rezerwacji:</strong> <?= htmlspecialchars($res['data_rezerwacji']) ?><br>
                            <strong>Status:</strong> <?= htmlspecialchars($res['status']) ?>
                        </p>
                        <div style=" display: flex; gap: 10px; align-items: center;">
                            <a href="szczegoly.php?id=<?= urlencode($res['id_pojazdu']) ?>" class="details-button" style="background-color:rgb(216, 2, 2); color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none;">Zobacz szczegóły</a>

                            <?php if ($res['status'] !== 'Anulowana'): ?>
                                <form method="POST" action="../functions/anuluj_rezerwacje.php">
                                    <input type="hidden" name="id_rezerwacji" value="<?= htmlspecialchars($res['id_rezerwacji']) ?>">
                                    <button type="submit" onclick="return confirm('Czy na pewno chcesz anulować tę rezerwację?')" style="background-color: rgb(216, 2, 2); color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer;">
                                        Anuluj rezerwację
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>



                    </div>


                    <?php
                }
            }
            ?>
            </div>

        <?php elseif ($page === 'ustawienia_konta'): ?>
            <h2>Ustawienia konta</h2>
            <?php if ($errors): ?>
                <div class="errors">
                    <ul>
                        <?php foreach ($errors as $err): ?>
                            <li><?= htmlspecialchars($err) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>

            <form method="post" action="?page=ustawienia_konta">
                <label for="imie">Imię</label>
                <input type="text" id="imie" name="imie" required value="<?= htmlspecialchars($userData['imie']) ?>">

                <label for="nazwisko">Nazwisko</label>
                <input type="text" id="nazwisko" name="nazwisko" required value="<?= htmlspecialchars($userData['nazwisko']) ?>">

                <label for="telefon">Telefon</label>
                <input type="tel" id="telefon" name="telefon" value="<?= htmlspecialchars($userData['telefon']) ?>">

                <label for="email">Email</label>
                <input type="email" id="email" name="email" required value="<?= htmlspecialchars($userData['email']) ?>">

                <hr style="margin: 25px 0; border: 1px solid #ccc;">

                <small>Zmiana hasła (opcjonalnie):</small>

                <label for="stare_haslo">Stare hasło</label>
                <input type="password" id="stare_haslo" name="stare_haslo">

                <label for="nowe_haslo1">Nowe hasło</label>
                <input type="password" id="nowe_haslo1" name="nowe_haslo1">

                <label for="nowe_haslo2">Powtórz nowe hasło</label>
                <input type="password" id="nowe_haslo2" name="nowe_haslo2">

                <button type="submit">Zapisz zmiany</button>
            </form>

        <?php endif; ?>
    </main>
</div>

</body>
</html>
<?php include '../includes/footer.php'; ?>

