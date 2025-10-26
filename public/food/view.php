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

        <!-- A TOUT MODIFIER -->
        <form>
            <label for="name">Nom :</label>
            <input type="text" id="name" value="<?= htmlspecialchars($pet["name"]) ?>" disabled />

            <label for="species">Espèce :</label>
            <select id="species" disabled>
                <?php foreach (Food::SPECIES as $key => $value) { ?>
                    <option value="<?= $key ?>" <?= $pet["species"] == $key ? "selected" : "" ?>><?= $value ?></option>
                <?php } ?>
            </select>

            <label for="nickname">Surnom :</label>
            <input type="text" id="nickname" value="<?= htmlspecialchars($pet["nickname"]) ?>" disabled />

            <fieldset>
                <legend>Sexe :</legend>

                <input type="radio" id="male" <?= $pet["sex"] == "male" ? "checked" : "" ?> disabled />
                <label for="male">Mâle</label>

                <input type="radio" id="female" <?= $pet["sex"] == "female" ? "checked" : "" ?> disabled />
                <label for="female">Femelle</label>
            </fieldset>

            <label for="age">Âge :</label>
            <input type="number" id="age" value="<?= htmlspecialchars($pet["age"]) ?>" disabled />

            <label for="color">Couleur :</label>
            <input type="color" id="color" value="<?= htmlspecialchars($pet["color"]) ?>" disabled />

            <fieldset>
                <legend>Personnalité :</legend>

                <?php foreach (Pet::PERSONALITIES as $key => $value) { ?>
                    <div>
                        <input type="checkbox" id="<?= $key ?>" <?= !empty($pet["personalities"]) && in_array($key, $pet["personalities"]) ? "checked" : "" ?> disabled />
                        <label for="<?= $key ?>"><?= $value ?></label>
                    </div>
                <?php } ?>
            </fieldset>

            <label for="size">Taille :</label>
            <input type="number" id="size" value="<?= htmlspecialchars($pet["size"]) ?>" disabled />

            <label for="notes">Notes :</label>
            <textarea id="notes" rows="4" cols="50" disabled><?= htmlspecialchars($pet["notes"]) ?></textarea>

            <a href="delete.php?id=<?= htmlspecialchars($pet["id"]) ?>">
                <button type="button">Supprimer</button>
            </a>
            <a href="edit.php?id=<?= htmlspecialchars($pet["id"]) ?>">
                <button type="button">Mettre à jour</button>
            </a>
        </form>
    </main>
</body>

</html>