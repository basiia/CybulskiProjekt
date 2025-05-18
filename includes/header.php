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
        header, footer { background: white; padding: 20px 40px; display: flex; justify-content: space-between; align-items: center; }
        .logo { font-weight: bold; font-size: 20px; }
        .auth-links a { margin-left: 20px; text-decoration: none; color: #111; }
        main { padding: 40px; max-width: 1200px; margin: auto; }
        .search-bar select, .search-bar button {
            padding: 12px; font-size: 16px; margin: 10px 10px 10px 0; border-radius: 8px; border: 1px solid #ccc;
        }
        .search-bar button { background: #d80000; color: white; border: none; font-weight: bold; cursor: pointer; }
        .car-card, .testimonial, .contact-form {
            background: white; padding: 20px; border-radius: 12px; box-shadow: 0 0 10px rgba(0,0,0,0.05); margin-bottom: 30px;
        }
        .car-card img { width: 100%; height: auto; }
        .car-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; }
        .filters, .why-us, .contact-form { margin-top: 40px; }
        .filters button, .why-us li::before {
            background: #eee; padding: 10px 20px; border: none; margin: 5px; border-radius: 8px;
        }
        .why-us li::before { content: "✔ "; color: red; margin-right: 5px; }
        .testimonial { font-style: italic; border-left: 4px solid red; padding-left: 20px; }
        .testimonial p { margin-bottom: 10px; }
        footer { flex-direction: column; text-align: center; font-size: 14px; }
        footer a { color: white; margin: 0 10px; text-decoration: none; }
        footer .footer-top { display: flex; flex-wrap: wrap; justify-content: space-between; width: 100%; max-width: 1200px; margin: 20px auto; }
    </style>
</head>
<body>
<header>
    <div class="logo">
        <a href="index.php" style="text-decoration: none; color: inherit;">Karpol</a>
    </div>
    <div class="auth-links">
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
</header>


<main>
