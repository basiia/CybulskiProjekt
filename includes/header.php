<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Karpol</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: Arial, sans-serif; }
        body { background: #f9f9f9; color: #111; }
        header, footer {
            background: white;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logo { font-weight: bold; font-size: 20px; }
        .auth-links a {
            margin-left: 20px;
            text-decoration: none;
            color: #111;
            cursor: pointer;
        }
        main { padding: 40px; max-width: 1200px; margin: auto; }

        .popup {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: #d4edda;
    color: #155724;
    padding: 20px 30px;
    border: 1px solid #c3e6cb;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    z-index: 1000;
    display: none;
    font-size: 18px;
    text-align: center;
}

    </style>
</head>
<body>

<header>
    <div class="logo">
        <a href="index.php" style="text-decoration: none; color: inherit;">Karpol</a>
    </div>
    <div class="auth-links">
        <?php if (isset($_SESSION['id_user'])): ?>
            <span>Zalogowano jako: <strong><?= htmlspecialchars($_SESSION['imie']) ?></strong> (<?= htmlspecialchars($_SESSION['rola']) ?>)</span>
            <?php if ($_SESSION['rola'] === 'Admin' || $_SESSION['rola'] === 'Pracownik'): ?>
                <a href="./admin_panel.php">Panel pracownika</a> |
            <?php elseif ($_SESSION['rola'] === 'Klient'): ?>
                <a href="./ustawienia.php">Ustawienia</a> |
            <?php endif; ?>
            <a onclick="logout()" class="logout">Wyloguj</a>
        <?php else: ?>
            <a href="./login.php">Zaloguj się</a> | <a href="./rejestracja.php">Zarejestruj</a>
        <?php endif; ?>
    </div>
</header>

<!-- Popupy -->
<?php if (isset($_SESSION['popup'])): ?>
    <div class="popup" id="popup"><?= htmlspecialchars($_SESSION['popup']) ?></div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const popup = document.getElementById('popup');
            if (popup) {
                popup.style.display = 'block';
                setTimeout(() => {
                    popup.style.display = 'none';
                }, 2500);
            }
        });
    </script>
    <?php unset($_SESSION['popup']); ?>
<?php endif; ?>

<div class="popup" id="logout-popup">Wylogowano pomyślnie.</div>


<main>
<script>
function logout() {
    fetch('logout.php', { method: 'POST' })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const popup = document.getElementById('logout-popup');
                popup.style.display = 'block';
                setTimeout(() => {
                    popup.style.display = 'none';
                    window.location.href = 'index.php';
                }, 500);
            } else {
                alert('Błąd podczas wylogowywania.');
            }
        })
        .catch(() => alert('Błąd połączenia z serwerem.'));
}

document.addEventListener('DOMContentLoaded', function() {
    // obsługa kliknięć – już w funkcji logout()
});
</script>
