<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Karpol</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body>
<header class="main-header">
    <div class="logo">
        <a href="../pages/index.php">Karpol</a>
    </div>
    <div class="auth-links">
        <?php if (isset($_SESSION['id_user'])): ?>
            <span>Zalogowano jako: <strong><?= htmlspecialchars($_SESSION['imie']) ?></strong> (<?= htmlspecialchars($_SESSION['rola']) ?>)</span>
            <?php if ($_SESSION['rola'] === 'Admin' || $_SESSION['rola'] === 'Pracownik' || $_SESSION['rola'] === 'Administrator'): ?>
                <a href="admin_panel.php">Panel pracownika</a>
            <?php else: ?>
                <a href="ustawienia.php">Ustawienia</a>
            <?php endif; ?>
            <a href="#" id="logoutButton">Wyloguj</a>
        <?php else: ?>
            <a href="login.php">Zaloguj się</a>
            <a href="rejestracja.php">Zarejestruj</a>
        <?php endif; ?>
    </div>
</header>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const logoutBtn = document.getElementById('logoutButton');
    if (logoutBtn) {
      logoutBtn.addEventListener('click', function (e) {
        e.preventDefault();
        fetch('../pages/logout.php') 
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              window.location.href = '../pages/index.php';
            } else {
              alert('Wylogowanie nie powiodło się.');
            }
          })
          .catch(error => {
            console.error('Błąd:', error);
            alert('Błąd połączenia z serwerem.');
          });
      });
    }
  });
</script>

</body>
</html>
