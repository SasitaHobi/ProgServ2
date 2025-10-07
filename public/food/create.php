<?php
require __DIR__ . '/../../src/utils/autoloader.php';

use Tools\ToolsManager;
use Tools\Tool;

// Création d'une instance de UsersManager
$toolsManager = new ToolsManager();

// Gère la soumission du formulaire
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupération des données du formulaire
    $name = $_POST["name"];
    $type = $_POST["type"];
    $date = $_POST["date"];
    $price = $_POST["price"];

    $errors = [];

    try {
        // Création d'un nouvel objet `User`
        $tool = new Tool(
            null, // Comme c'est une création, l'ID est null. La base de données l'assignera automatiquement.
            $name,
            $type,
            new DateTime($date),
            $price
        );
    } catch (Exception $e) {
        $errors[] = $e->getMessage();
    }

    // S'il n'y a pas d'erreurs, ajout de l'utilisateur
    if (empty($errors)) {
        try {
            // Ajout de l'utilisateur à la base de données
            $toolsManager->addTool($tool);

            // Redirection vers la page d'accueil avec tous les utilisateurs
            header("Location: index.php");
            exit();
        } catch (PDOException $e) {
            // Liste des codes d'erreurs : https://en.wikipedia.org/wiki/SQLSTATE
            if ($e->getCode() === "23000") {
                // Erreur de contrainte d'unicité (par exemple, email déjà utilisé)
                $errors[] = "Le nom de l'outil est déjà utilisé.";
            } else {
                $errors[] = "Erreur lors de l'interaction avec la base de données : " . $e->getMessage();
            }
        } catch (Exception $e) {
            $errors[] = "Erreur inattendue : " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light dark">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <link rel="stylesheet" href="../assets/css/custom.css">

    <title>Créer un nouvel outil | MyApp</title>
</head>

<body>
    <main class="container">
        <h1>Créer un nouvel outil</h1>

        <p><a href="../index.php">Accueil</a> > <a href="index.php">Gestion des outils</a> > Création d'un outil</p>

        <?php if ($_SERVER["REQUEST_METHOD"] === "POST") { ?>
            <?php if (empty($errors)) { ?>
                <p style="color: green;">Le formulaire a été soumis avec succès !</p>
            <?php } else { ?>
                <p style="color: red;">Le formulaire contient des erreurs :</p>
                <ul>
                    <?php foreach ($errors as $error) { ?>
                        <li><?php echo $error; ?></li>
                    <?php } ?>
                </ul>
            <?php } ?>
        <?php } ?>

        <form action="create.php" method="POST">
            <label for="name">Nom</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($name ?? ''); ?>" required minlength="2">

            <label for="type">Type</label>
            <input type="text" id="type" name="type" value="<?= htmlspecialchars($type ?? ''); ?>" required minlength="2">
            
            <label for="date">Date d'achat</label>
            <input type="date" id="date" name="date" value="<?= htmlspecialchars($date ?? ''); ?>" required min="1950-01-01" max="2025-12-31">

            <label for="price">Prix</label>
            <input type="number" id="price" name="price" value="<?= htmlspecialchars($price ?? ''); ?>" required min="0">

            <button type="submit">Créer</button>
        </form>
    </main>
</body>

</html>