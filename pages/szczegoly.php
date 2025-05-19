<?php include '../includes/header.php'; ?>
<?php
include '../includes/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM Pojazdy WHERE id_pojazdu = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $pojazd = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($pojazd):
?>
<style>
.detail-container {
    max-width: 1100px;
    margin: 40px auto;
    font-family: Arial, sans-serif;
}
.detail-top {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}
.detail-left img {
    max-width: 500px;
    width: 100%;
    border-radius: 10px;
}
.detail-right {
    flex: 1;
    padding-left: 40px;
}
.detail-right h1 {
    font-size: 32px;
    margin-bottom: 10px;
}
.detail-right .price {
    color: #d80000;
    font-size: 28px;
    font-weight: bold;
}
.detail-right .btn {
    background: #d80000;
    color: white;
    padding: 12px 24px;
    margin-top: 20px;
    display: inline-block;
    border-radius: 8px;
    text-decoration: none;
    font-weight: bold;
}
.detail-thumbs img {
    width: 100px;
    margin: 10px 10px 0 0;
    border-radius: 8px;
}
.section {
    margin-top: 40px;
}
.section h2 {
    font-size: 24px;
    margin-bottom: 15px;
}
.section .specs {
    display: flex;
    gap: 40px;
    flex-wrap: wrap;
}
.specs div {
    min-width: 150px;
}
.similar-vehicles {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}
.similar-card {
    background: #fff;
    border-radius: 10px;
    width: 250px;
    box-shadow: 0 0 10px rgba(0,0,0,0.05);
    padding: 15px;
    text-align: center;
}
.similar-card img {
    width: 100%;
    border-radius: 8px;
}
.similar-card .price {
    color: #d80000;
    font-weight: bold;
}
.similar-card a {
    display: inline-block;
    margin-top: 10px;
    background: #d80000;
    color: white;
    padding: 8px 14px;
    border-radius: 6px;
    text-decoration: none;
}
</style>

<div class="detail-container">
    <div class="detail-top">
        <div class="detail-left">
            <img src="../assets/car_place.png" alt="Auto">
        </div>
        <div class="detail-right">
            <h1><?= htmlspecialchars($pojazd['marka'] . ' ' . $pojazd['model']) ?>, <?= $pojazd['rok_produkcji'] ?></h1>
            <div class="price"><?= number_format($pojazd['cena'], 0, ',', ' ') ?> zł</div>
            <a href="rezerwacja.php?id=<?= $pojazd['id_pojazdu'] ?>" class="btn">Skontaktuj się</a>
            <div class="detail-thumbs">
                <img src="../assets/car_place.png" alt="">
                <img src="../assets/car_place.png" alt="">
            </div>
        </div>
    </div>

    <div class="section">
        <h2>Charakterystyka</h2>
        <div class="specs">
            <div><strong>Rok produkcji:</strong><br><?= $pojazd['rok_produkcji'] ?></div>
            <div><strong>Paliwo:</strong><br><?= $pojazd['rodzaj_paliwa'] ?></div>
            <div><strong>Kolor:</strong><br><?= $pojazd['kolor'] ?></div>
            <div><strong>Przebieg:</strong><br><?= number_format($pojazd['przebieg'], 0, ',', ' ') ?> km</div>
        </div>
    </div>

    <div class="section">
        <h2>Opis pojazdu</h2>
        <p><?= nl2br(htmlspecialchars($pojazd['stan_techniczny'])) ?></p>
    </div>

    <?php
    // podobne
    $stmt_similar = $pdo->prepare("
        SELECT * FROM Pojazdy 
        WHERE id_pojazdu != :id 
        AND marka = :marka 
        ORDER BY RAND() 
        LIMIT 3
    ");
    $stmt_similar->execute([
        'id' => $pojazd['id_pojazdu'],
        'marka' => $pojazd['marka']
    ]);
    $similar = $stmt_similar->fetchAll(PDO::FETCH_ASSOC);
    if ($similar):
    ?>
    <div class="section">
        <h2>Podobne oferty</h2>
        <div class="similar-vehicles">
            <?php foreach ($similar as $car): ?>
                <div class="similar-card">
                    <img src="../assets/car_place.png" alt="<?= $car['model'] ?>">
                    <h3><?= htmlspecialchars($car['marka'] . ' ' . $car['model']) ?></h3>
                    <div class="price"><?= number_format($car['cena'], 0, ',', ' ') ?> zł</div>
                    <p><?= number_format($car['przebieg'], 0, ',', ' ') ?> km</p>
                    <p><?= $car['rodzaj_paliwa'] ?></p>
                    <a href="szczegoly.php?id=<?= $car['id_pojazdu'] ?>">Zobacz więcej</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php
    else:
        echo "<p>Nie znaleziono pojazdu.</p>";
    endif;
} else {
    echo "<p>Brak ID pojazdu w zapytaniu.</p>";
}
include '../includes/footer.php';
?>
