<?php
include '../includes/db.php';
include '../includes/header.php';

// Pobierz wszystkie opinie
$stmt = $pdo->query("SELECT * FROM opinie ORDER BY data_opinii DESC");
$opinie = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Opinie naszych klientów</h1>

<div class="opinie-container" style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: center; padding: 20px;">
    <?php if ($opinie): ?>
        <?php foreach ($opinie as $opinia): ?>
            <div class="opinia-card" style="background: #f8f8f8; border-radius: 10px; padding: 20px; max-width: 350px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                <p style="font-style: italic;">“<?= htmlspecialchars($opinia['tresc']) ?>”</p>
                <p style="margin-top: 10px;"><strong><?= htmlspecialchars($opinia['imie_nazwisko']) ?>, <?= htmlspecialchars($opinia['miasto']) ?></strong></p>
                <p style="color: gray; font-size: 0.9em;"><?= date('d.m.Y', strtotime($opinia['data_opinii'])) ?></p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Brak opinii do wyświetlenia.</p>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>
