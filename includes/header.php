<<<<<<< HEAD
=======
<?php
session_start();
?>
>>>>>>> c9d6b7b5abbae0e6a3ed725c5ca0c1352febc04c
<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8" />
  <title>Karpol</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; font-family: Arial, sans-serif; }
    body { background: #f6f6f6; color: #111; }
    header, footer { background: white; padding: 20px 40px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; }
    .logo { font-weight: bold; font-size: 20px; }
    .auth-links a { margin-left: 20px; text-decoration: none; color: #111; }

    main { max-width: 1200px; margin: auto; }

    .hero {
      background: white;
      padding: 40px;
      display: grid;
      grid-template-columns: 1fr 1fr;
      align-items: center;
      gap: 40px;
    }

    .hero h1 {
      font-size: 36px;
      margin-bottom: 30px;
    }

    .filters form {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      margin-bottom: 20px;
    }

    select, button {
      padding: 12px 16px;
      font-size: 16px;
      border-radius: 8px;
      border: 1px solid #ccc;
    }

    .filters button {
      background: #d80000;
      color: white;
      border: none;
      font-weight: bold;
      cursor: pointer;
    }

    .car-grid {
      display: flex;
      gap: 20px;
      padding: 40px;
      background: white;
      justify-content: center;
    }

    .car-card {
      background: white;
      border: 1px solid #eee;
      border-radius: 12px;
      padding: 20px;
      width: 260px;
      text-align: center;
      box-shadow: 0 0 8px rgba(0,0,0,0.03);
    }

    .car-card img {
      width: 100%;
      height: auto;
      margin-bottom: 15px;
    }

    .car-card p {
      margin: 4px 0;
    }

    .button {
      background: #d80000;
      color: white;
      padding: 10px 16px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-weight: bold;
      margin-top: 10px;
    }

    .main-content {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      padding: 40px;
      gap: 40px;
      background: white;
    }

    .section {
      flex: 1;
      min-width: 300px;
    }

    .testimonial {
      background: #fff;
      padding: 20px;
      border-radius: 12px;
      border-left: 4px solid red;
      font-style: italic;
    }

    .contact-form input, .contact-form textarea {
      width: 100%;
      padding: 12px;
      border-radius: 8px;
      border: 1px solid #ccc;
      margin-bottom: 10px;
    }

    .contact-form button {
      background: #d80000;
      color: white;
      padding: 12px 20px;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
    }

    footer {
      background: #111;
      color: white;
      padding: 40px;
      font-size: 14px;
    }

    footer a {
      color: white;
      text-decoration: none;
      margin: 0 10px;
    }

    .footer-columns {
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
    }
  </style>
</head>
<body>

<header>
<<<<<<< HEAD
  <div class="logo">Karpol</div>
  <div class="auth-links">
  <a href="../pages/login.php">Zaloguj się</a> | <a href="../pages/rejestracja.php">Zarejestruj się
  </a>
</header>

=======
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


>>>>>>> c9d6b7b5abbae0e6a3ed725c5ca0c1352febc04c
<main>
