<?php
require __DIR__ . '/../../src/utils/autoloader.php';

use Food\FoodManager;

$foodManager = new FoodManager();

// On vérifie si l'ID de l'aliment est passé dans l'URL
if (isset($_GET["id"])) {
    $foodId = $_GET["id"];

    // On récupère l'aliment correspondant à l'ID
    $food = $foodManager->getFood($foodId);

    if (!$food) {
        header("Location: index.php");
        exit();
    }
} else {
    // Si l'ID n'est pas passé dans l'URL, on redirige vers la page d'accueil
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light dark">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <link rel="stylesheet" href="css/custom.css">

    <title>Visualise et modifie un aliment | Gestionnaire d'aliments</title>
</head>

<body>
    <main class="container">
        <h1>Visualise un aliment</h1>
        <p><a href="index.php">Retour à l'accueil</a></p>
        <p>Utilise cette page pour visualiser un aliment.</p>

        <!-- A VERIFIER, MODIF FROM PETS TO FOOD -->
        <form>
            <label for="name">Nom de l'aliment :</label>
            <input type="text" id="name" value="<?= htmlspecialchars($food["name"]) ?>" disabled />

            <label for="shop">Magasin :</label>
            <input type="text" id="shop" value="<?= htmlspecialchars($food['shop']) ?>" disabled />

            <label for="qty">Quantité :</label>
            <input type="number" id="qty" value="<?= htmlspecialchars($food['qty']) ?>" disabled />

            <label for="unit">Unité :</label>
            <select id="unit" disabled>
                <?php foreach (Food::UNITS as $key => $value) { ?>
                    <option value="<?= $key ?>" <?= $food['unit'] == $key ? 'selected' : '' ?>><?= $value ?></option>
                <?php } ?>
            </select>

            <label for="spot">Emplacement (lieu de stockage) :</label>
            <select id="spot" disabled>
                <?php foreach (Food::SPOTS as $key => $value) { ?>
                    <option value="<?= $key ?>" <?= $food['spot'] == $key ? 'selected' : '' ?>><?= $value ?></option>
                <?php } ?>
            </select>

            <label for="peremption">Date de péremption :</label>
            <input type="date" id="peremption" value="<?= htmlspecialchars($food['peremption']) ?>" disabled />

            <label for="notes">Notes :</label>
            <textarea id="notes" rows="4" cols="50" disabled><?= ($food["notes"]) ?></textarea>

            <a href="delete.php?id=<?= htmlspecialchars($food["id"]) ?>">
                <button type="button">Supprimer</button>
            </a>
            <a href="edit.php?id=<?= htmlspecialchars($food["id"]) ?>">
                <button type="button">Mettre à jour</button>
            </a>
        </form>
    </main>
</body>

</html>