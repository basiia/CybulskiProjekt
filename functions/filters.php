<!-- Wyszukiwanie -->
<div class="search-bar">
    <form action="./search.php" method="get">
        <select name="marka" id="marka">
            <option value="">Wybierz markę</option>
            <?php
            if ($stmt_marki->rowCount() > 0) {
                while ($row = $stmt_marki->fetch(PDO::FETCH_ASSOC)) {
                    echo '<option value="' . htmlspecialchars($row['marka']) . '"';
                    // Sprawdzamy, czy marka jest już wybrana
                    if (isset($_GET['marka']) && $_GET['marka'] == $row['marka']) {
                        echo ' selected';
                    }
                    echo '>' . htmlspecialchars($row['marka']) . '</option>';
                }
            }
            ?>
        </select>

        <select name="model" id="model" <?php echo isset($_GET['marka']) ? '' : 'disabled'; ?>>
            <option value="">Wybierz model</option>
            <?php
            if (isset($_GET['marka']) && !empty($_GET['marka'])) {
                // Dynamicznie ładowanie modeli na podstawie wybranej marki
                // Sprawdzamy dostępne modele dla danej marki
                // Zakładając, że masz odpowiednią logikę w backendzie
                $stmt_models = $pdo->prepare("SELECT DISTINCT model FROM vehicles WHERE marka = ?");
                $stmt_models->execute([$_GET['marka']]);
                while ($row = $stmt_models->fetch(PDO::FETCH_ASSOC)) {
                    echo '<option value="' . htmlspecialchars($row['model']) . '"';
                    if (isset($_GET['model']) && $_GET['model'] == $row['model']) {
                        echo ' selected';
                    }
                    echo '>' . htmlspecialchars($row['model']) . '</option>';
                }
            }
            ?>
        </select>

        <input type="number" name="rocznik_od" id="rocznik_od" min="1970" max="<?php echo date('Y'); ?>" placeholder="Rocznik od" 
               value="<?php echo isset($_GET['rocznik_od']) ? htmlspecialchars($_GET['rocznik_od']) : ''; ?>" />

        <input type="number" name="rocznik_do" id="rocznik_do" min="1970" max="<?php echo date('Y'); ?>" placeholder="Rocznik do" 
               value="<?php echo isset($_GET['rocznik_do']) ? htmlspecialchars($_GET['rocznik_do']) : ''; ?>" />

        <select name="paliwo" id="paliwo">
            <option value="">Wybierz paliwo</option>
            <?php
            if ($stmt_paliwa->rowCount() > 0) {
                while ($row = $stmt_paliwa->fetch(PDO::FETCH_ASSOC)) {
                    echo '<option value="' . htmlspecialchars($row['rodzaj_paliwa']) . '"';
                    if (isset($_GET['paliwo']) && $_GET['paliwo'] == $row['rodzaj_paliwa']) {
                        echo ' selected';
                    }
                    echo '>' . htmlspecialchars($row['rodzaj_paliwa']) . '</option>';
                }
            }
            ?>
        </select>

        <button type="submit">Szukaj</button>
    </form>
</div>





<!-- Skrypt JavaScript do dynamicznego ładowania modeli -->
<script>
document.getElementById('marka').addEventListener('change', function () {
    var marka = this.value;

    // Resetujemy pole modeli
    document.getElementById('model').innerHTML = '<option value="">Wybierz model</option>';
    document.getElementById('model').disabled = true;

    if (marka !== "") {
        // Zapytanie AJAX do pobrania modeli
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "?marka=" + marka, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);

                // Wypełniamy modele
                if (response.models.length > 0) {
                    var modelSelect = document.getElementById('model');
                    modelSelect.disabled = false;
                    response.models.forEach(function (model) {
                        var option = document.createElement('option');
                        option.value = model;
                        option.textContent = model;
                        modelSelect.appendChild(option);
                    });
                }
            }
        };
        xhr.send();
    }
});
</script>