<?php
session_start();
session_unset();
session_destroy();

echo "<p>Wylogowano pomyślnie.</p>";
echo "<a href='./index.php'>Powrót do strony głównej</a>";
?>
