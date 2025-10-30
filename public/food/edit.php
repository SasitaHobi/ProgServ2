<?php
require __DIR__ . '/../../src/utils/autoloader.php';

use Food\Food;
use Food\FoodManager;

$foodManager = new FoodManager();

// vérification de l'ID
if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = (int) $_GET['id'];