<?php
session_start();
?>
<header>
    <div class="top-bar">
        <h1><a href="./index.php">Karpol</a></h1>
        <div class="user-menu">
            <?php
            if (isset($_SESSION['id_user'])) {
                echo "<span>Zalogowano jako: <strong>{$_SESSION['imie']}</strong> ({$_SESSION['rola']})</span> ";
                if ($_SESSION['rola'] === 'Admin' || $_SESSION['rola'] === 'Pracownik') {
                    echo "<a href='./admin_panel.php'>Panel pracownika</a> | ";
                } elseif ($_SESSION['rola'] === 'Klient') {
                    echo "<a href='./moje_rezerwacje.php'>Moje rezerwacje</a> | ";
                }
                echo "<a href='./logout.php'>Wyloguj</a>";
            } else {
                echo "<a href='./login.php'>Zaloguj się</a> | <a href='./rejestracja.php'>Zarejestruj</a>";
            }
            ?>
        </div>
    </div>
</header>

<style>
    header {
        background-color: #333;
        color: white;
        padding: 10px 0;
        text-align: center;
    }

    .top-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .top-bar h1 a {
        color: white;
        text-decoration: none;
        font-size: 24px;
    }

    .user-menu {
        font-size: 14px;
    }

    .user-menu a {
        color: white;
        text-decoration: none;
        margin: 0 10px;
    }

    .user-menu span {
        margin-right: 10px;
    }
</style>
