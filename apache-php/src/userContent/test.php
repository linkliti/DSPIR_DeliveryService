<?php
for ($i = 2; $i <= 9; $i++) {
    echo password_hash('workPass'. $i, PASSWORD_DEFAULT);
    echo '<br>';
}
?>