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
<<<<<<< HEAD
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

=======
include '../includes/db.php';
include '../includes/header.php';

// Pobieranie danych do formularza
$stmt_marki     = $pdo->query("SELECT DISTINCT marka FROM Pojazdy");
$stmt_paliwa    = $pdo->query("SELECT DISTINCT rodzaj_paliwa FROM Pojazdy");
$stmt_rocznik   = $pdo->query("SELECT DISTINCT rok_produkcji FROM Pojazdy ORDER BY rok_produkcji DESC");
$stmt_locations = $pdo->query("SELECT id_lokacji, miasto FROM Lokacje");

// Polecane pojazdy z filtrem lokalizacji (jeśli podana)
if (isset($id_lokacji)) {
    $stmt_recommended = $pdo->prepare("SELECT * FROM Pojazdy WHERE status = 'Dostępny' AND id_lokacji = :id_lokacji ORDER BY RAND() LIMIT 3");
    $stmt_recommended->bindParam(':id_lokacji', $id_lokacji, PDO::PARAM_INT);
    $stmt_recommended->execute();
} else {
    $stmt_recommended = $pdo->query("SELECT * FROM Pojazdy WHERE status = 'Dostępny' ORDER BY RAND() LIMIT 3");
}


// Sprawdzenie, czy jest przekazana lokalizacja przez GET (z linków)
$selected_location = null;
if (isset($_GET['id_lokacji'])) {
    $id_lokacji = (int)$_GET['id_lokacji'];
    $stmt_loc = $pdo->prepare("SELECT miasto FROM Lokacje WHERE id_lokacji = ?");
    $stmt_loc->execute([$id_lokacji]);
    $selected_location = $stmt_loc->fetchColumn();
}
?>

<?php if ($selected_location): ?>
    <p>Jesteś w lokalizacji: <strong><?= htmlspecialchars($selected_location) ?></strong></p>
<?php endif; ?>

<h1>Znajdź swój idealny samochód</h1>

<form class="search-bar" method="GET" action="search.php">
    <select name="marka" id="marka">
        <option value="">Marka</option>
        <?php while ($row = $stmt_marki->fetch()): ?>
            <option value="<?= htmlspecialchars($row['marka']) ?>"><?= htmlspecialchars($row['marka']) ?></option>
        <?php endwhile; ?>
    </select>

    <select name="model" id="model" disabled>
        <option value="">Model</option>
    </select>

    <select name="paliwo">
        <option value="">Paliwo</option>
        <?php while ($row = $stmt_paliwa->fetch()): ?>
            <option value="<?= htmlspecialchars($row['rodzaj_paliwa']) ?>"><?= htmlspecialchars($row['rodzaj_paliwa']) ?></option>
        <?php endwhile; ?>
    </select>

    <select name="rocznik">
        <option value="">Rocznik</option>
        <?php while ($row = $stmt_rocznik->fetch()): ?>
            <option value="<?= htmlspecialchars($row['rok_produkcji']) ?>"><?= htmlspecialchars($row['rok_produkcji']) ?></option>
        <?php endwhile; ?>
    </select>

    <?php if ($selected_location): ?>
        <!-- Przekazujemy id_lokacji do search.php, aby filtrować tam po lokalizacji -->
        <input type="hidden" name="id_lokacji" value="<?= (int)$id_lokacji ?>">
    <?php endif; ?>

    <button type="submit">Szukaj</button>
</form>

<h2>Polecane samochody</h2>
<div class="car-grid">
    <?php while ($car = $stmt_recommended->fetch()): ?>
        <div class="car-card">
            <img src="../assets/car_place.png" alt="<?= htmlspecialchars($car['model']) ?>">
            <h3><?= htmlspecialchars($car['marka'] . ' ' . $car['model']) ?></h3>
            <p><strong><?= number_format($car['cena'], 0, ',', ' ') ?> zł</strong></p>
            <p><?= number_format($car['przebieg'], 0, ',', ' ') ?> km</p>
            <p><?= htmlspecialchars($car['rodzaj_paliwa']) ?></p>
            <a href="szczegoly.php?id=<?= urlencode($car['id_pojazdu']) ?>" 
               style="display: inline-block; padding: 10px 20px; background: #d80000; color: white; border-radius: 8px; text-decoration: none; font-weight: bold;">
               Zobacz więcej
            </a>
        </div>
    <?php endwhile; ?>
</div>

<div class="filters">
    <h2>Filtruj po lokalizacji</h2>
    <?php
    // resetujemy wynik, bo wcześniej iterowaliśmy
    $stmt_locations->execute();
    while ($row = $stmt_locations->fetch()):
    ?>
        <a href="?id_lokacji=<?= (int)$row['id_lokacji'] ?>" 
           style="display:inline-block; margin: 5px; padding: 8px 15px; background: #d80000; color: white; border-radius: 5px; text-decoration: none;">
           <?= htmlspecialchars($row['miasto']) ?>
        </a>
    <?php endwhile; ?>
</div>

<div class="why-us">
    <h2>Dlaczego my?</h2>
    <ul>
        <li>Sprawdzone pojazdy</li>
        <li>Pełna historia serwisowa</li>
        <li>Bezpieczne transakcje</li>
        <li>Szybka obsługa</li>
    </ul>
</div>

<div class="testimonial">
    <h2>Opinie klientów</h2>
    <p>“Bardzo profesjonalna obsługa i szybki kontakt. Auto w idealnym stanie. Polecam z całego serca!”</p>
    <p><strong>Jan Kowalski, Warszawa</strong> – 20.03.2025</p>
    <button>Zobacz więcej</button>
</div>

<div class="contact-form">
    <h2>Formularz kontaktowy</h2>
    <form method="POST" action="kontakt.php">
        <input type="text" name="name" placeholder="Imię i Nazwisko" required><br><br>
        <input type="email" name="email" placeholder="Email" required><br><br>
        <input type="tel" name="telefon" placeholder="Telefon"><br><br>
        <textarea name="wiadomosc" placeholder="Wiadomość" rows="5" required></textarea><br><br>
        <button type="submit">Skontaktuj się</button>
    </form>
</div>
>>>>>>> c9d6b7b5abbae0e6a3ed725c5ca0c1352febc04c

<script>
// Dynamiczne ładowanie modeli
document.getElementById('marka').addEventListener('change', function () {
    const selectedMarka = this.value;
    const modelSelect = document.getElementById('model');
    modelSelect.innerHTML = '<option value="">Wczytywanie...</option>';
    modelSelect.disabled = true;

    if (selectedMarka) {
        fetch('../functions/get_models.php?marka=' + encodeURIComponent(selectedMarka))
            .then(response => response.json())
            .then(models => {
                modelSelect.innerHTML = '<option value="">Model</option>';
                models.forEach(model => {
                    const option = document.createElement('option');
                    option.value = model;
                    option.textContent = model;
                    modelSelect.appendChild(option);
                });
                modelSelect.disabled = false;
            });
    } else {
        modelSelect.innerHTML = '<option value="">Model</option>';
        modelSelect.disabled = true;
    }
});
</script>

<?php include '../includes/footer.php'; ?>
