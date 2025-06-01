<?php
include '../includes/db.php';
include '../includes/header.php';

// Pobierz wszystkie opinie
$stmt = $pdo->query("SELECT * FROM opinie ORDER BY data_opinii DESC");
$opinie = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<link rel="stylesheet" href="../styles/opinie-styled.css">

<section class="opinie-section">
    <h1 class="section-title">Opinie naszych klientów</h1>

    <?php if ($opinie): ?>
        <div class="opinie-grid">
            <?php foreach ($opinie as $opinia): ?>
                <div class="opinia-card">
                    <p class="opinia-text">“<?= htmlspecialchars($opinia['tresc']) ?>”</p>
                    <p class="opinia-author">
                        <strong><?= htmlspecialchars($opinia['imie_nazwisko']) ?></strong>, <?= htmlspecialchars($opinia['miasto']) ?>
                    </p>
                    <p class="opinia-date"><?= date('d.m.Y', strtotime($opinia['data_opinii'])) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="no-opinie">Brak opinii do wyświetlenia.</p>
    <?php endif; ?>
</section>

<?php include '../includes/footer.php'; ?>
