<?php include '../includes/header.php'; ?>
<?php include '../includes/db.php'; ?>

<!-- Sekcja HERO -->
<section style="position: relative; background: white; padding: 120px 40px 80px; overflow: hidden;">
  <!-- Obraz auta po prawej stronie -->
  <img src="../assets/car.png" alt="Auto"
       style="position: absolute; bottom: 0; right: 0; max-width: 700px; z-index: 1;" />

  <!-- Lewa kolumna z tekstem i filtrami -->
  <div style="position: relative; z-index: 2; padding-left: 40px; max-width: 1000px;">
    <h1 style="font-size: 48px; font-weight: bold; line-height: 1.2; margin-bottom: 40px;">
      Znajdź swój<br>idealny samochód
    </h1>

    <!-- Formularz filtrów -->
    <form action="search.php" method="get" style="display: flex; gap: 20px; flex-wrap: nowrap; align-items: center;">
      <select name="marka" style="padding: 16px 20px; font-size: 16px; border-radius: 10px; border: 1px solid #ccc; min-width: 150px;">
        <option value="">Marka</option>
        <option>Audi</option><option>BMW</option><option>Volkswagen</option>
      </select>

      <select name="model" style="padding: 16px 20px; font-size: 16px; border-radius: 10px; border: 1px solid #ccc; min-width: 150px;">
        <option value="">Model</option>
        <option>A5</option><option>X5</option><option>Golf</option>
      </select>

      <select name="paliwo" style="padding: 16px 20px; font-size: 16px; border-radius: 10px; border: 1px solid #ccc; min-width: 150px;">
        <option value="">Paliwo</option>
        <option>Benzyna</option><option>Diesel</option><option>Elektryczny</option><option>Hybryda</option>
      </select>

      <select name="rocznik" style="padding: 16px 20px; font-size: 16px; border-radius: 10px; border: 1px solid #ccc; min-width: 150px;">
        <option value="">Rocznik</option>
        <?php for ($i = date('Y'); $i >= 1970; $i--): ?>
          <option><?= $i ?></option>
        <?php endfor; ?>
      </select>

      <button type="submit" style="padding: 16px 28px; font-size: 16px; font-weight: bold; border-radius: 10px; background: #d80000; color: white; border: none; cursor: pointer;">
        Szukaj
      </button>
    </form>

    <!-- Wyszukiwanie zaawansowane -->
    <div style="display: flex; align-items: center; gap: 8px; margin-top: 20px;">
      <img src="../assets/filter-icon.png" alt="Filtr" style="width: 20px; height: 20px;">
      <span style="font-size: 14px; color: #333;">Wyszukiwanie zaawansowane</span>
    </div>
  </div>
</section>

<!-- Polecane samochody -->
<?php
$stmt = $pdo->query("SELECT * FROM Pojazdy WHERE status = 'Dostępny' ORDER BY RAND() LIMIT 3");
$polecane = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section style="background: white; padding: 40px 20px;">
  <h2 style="font-size: 26px; font-weight: bold; margin-bottom: 30px;">Polecane samochody</h2>
  <div class="car-grid" style="display: flex; gap: 20px; justify-content: center; flex-wrap: wrap;">
    <?php foreach ($polecane as $auto): ?>
      <div class="car-card" style="background: white; border: 1px solid #eee; border-radius: 12px; padding: 20px; width: 260px; text-align: center; box-shadow: 0 0 8px rgba(0,0,0,0.03);">
        <img src="../assets/car_place.png" alt="<?= htmlspecialchars($auto['marka']) ?> <?= htmlspecialchars($auto['model']) ?>" style="width: 100%; height: auto; border-radius: 8px; margin-bottom: 10px;">
        <h3><?= htmlspecialchars($auto['marka']) ?> <?= htmlspecialchars($auto['model']) ?></h3>
        <p><strong><?= number_format($auto['cena'], 2, ',', '.') ?> zł</strong></p>
        <p><?= number_format($auto['przebieg'], 0, ',', '.') ?> km</p>
        <p><?= htmlspecialchars($auto['rodzaj_paliwa']) ?></p>
        <a href="szczegoly.php?id=<?= $auto['id_pojazdu'] ?>">
          <button class="button" style="background: #d80000; color: white; padding: 10px 16px; border: none; border-radius: 8px; cursor: pointer; font-weight: bold; margin-top: 10px;">
            Zobacz więcej
          </button>
        </a>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- Sekcja: Filtruj + Dlaczego + Opinie + Formularz -->
<div style="padding: 60px 40px; background: #f6f6f6;">

  <!-- FILTRUJ i DLACZEGO MY – jedna linia -->
  <div style="display: flex; justify-content: space-between; gap: 40px; flex-wrap: wrap; margin-bottom: 40px;">

    <!-- Filtruj po lokalizacji -->
    <div style="flex: 1; min-width: 250px;">
      <h3 style="font-size: 18px; font-weight: bold; margin-bottom: 20px;">Filtruj po lokalizacji</h3>
      <div style="display: flex; flex-wrap: wrap; gap: 10px;">
        <button style="padding: 10px 16px; background: white; border: 1px solid #ccc; border-radius: 6px; cursor: pointer;">Warszawa</button>
        <button style="padding: 10px 16px; background: white; border: 1px solid #ccc; border-radius: 6px; cursor: pointer;">Kraków</button>
        <button style="padding: 10px 16px; background: white; border: 1px solid #ccc; border-radius: 6px; cursor: pointer;">Wrocław</button>
        <button style="padding: 10px 16px; background: white; border: 1px solid #ccc; border-radius: 6px; cursor: pointer;">Poznań</button>
        <button style="padding: 10px 16px; background: white; border: 1px solid #ccc; border-radius: 6px; cursor: pointer;">Gdańsk</button>
      </div>
    </div>

    <!-- Dlaczego my -->
    <div style="flex: 1; min-width: 250px;">
      <h3 style="font-size: 18px; font-weight: bold; margin-bottom: 20px;">Dlaczego my?</h3>
      <ul style="list-style: none; padding-left: 0; font-size: 14px;">
        <li style="margin-bottom: 8px;">✔ Sprawdzone pojazdy</li>
        <li style="margin-bottom: 8px;">✔ Pełna historia serwisowa</li>
        <li style="margin-bottom: 8px;">✔ Bezpieczne transakcje</li>
        <li style="margin-bottom: 8px;">✔ Szybka obsługa</li>
      </ul>
    </div>

  </div>

  <!-- OPINIE i FORMULARZ – pod spodem -->
  <div style="display: flex; justify-content: space-between; gap: 40px; flex-wrap: wrap;">

    <!-- Opinie klientów -->
    <div style="flex: 1; min-width: 300px;">
      <h3 style="font-size: 18px; font-weight: bold; margin-bottom: 20px;">Opinie klientów</h3>
      <div style="background: white; padding: 20px; border-radius: 10px; border-left: 4px solid red;">
        <p style="font-style: italic; font-size: 15px; line-height: 1.6;">
          “Bardzo profesjonalna obsługa i szybki kontakt. Auto w idealnym stanie. Polecam z całego serca!”
        </p>
        <p style="font-weight: bold; margin-top: 10px;">Jan Kowalski, Warszawa</p>
        <p style="font-size: 13px; color: #777;">20.03.2025</p>
        <button style="margin-top: 10px; padding: 8px 12px; background: #d80000; color: white; border: none; border-radius: 6px; cursor: pointer;">
          Zobacz więcej
        </button>
      </div>
    </div>

    <!-- Formularz kontaktowy -->
    <div style="flex: 1; min-width: 300px;">
      <h3 style="font-size: 18px; font-weight: bold; margin-bottom: 20px;">Formularz kontaktowy</h3>
      <form>
        <input type="text" placeholder="Imię i Nazwisko" style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 6px; margin-bottom: 10px;" />
        <input type="email" placeholder="Email" style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 6px; margin-bottom: 10px;" />
        <input type="tel" placeholder="Telefon" style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 6px; margin-bottom: 10px;" />
        <textarea rows="5" placeholder="Wiadomość" style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 6px; margin-bottom: 10px;"></textarea>
        <button type="submit" style="width: 100%; padding: 12px; background: #d80000; color: white; font-weight: bold; border: none; border-radius: 6px; cursor: pointer;">
          Skontaktuj się
        </button>
      </form>
    </div>

  </div>
</div>


<?php include '../includes/footer.php'; ?>
