<?php
if (isset($_SESSION['currentuser'])) {
    $currentusername = $_SESSION['currentusername'];
    echo "До скорых встреч, $currentusername!";
}

session_destroy();