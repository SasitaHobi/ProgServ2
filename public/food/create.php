<?php
const DATABASE_CONFIGURATION_FILE = __DIR__ . '/../../src/config/database.ini';
require __DIR__ . '/../../src/utils/autoloader.php';


// Documentation : https://www.php.net/manual/fr/function.parse-ini-file.php
$config = parse_ini_file(DATABASE_CONFIGURATION_FILE, true);

if (!$config) {
    throw new Exception("Erreur lors de la lecture du fichier de configuration : " . DATABASE_CONFIGURATION_FILE);
}

$host = $config['host'];
$port = $config['port'];
$database = $config['database'];
$username = $config['username'];
$password = $config['password'];

// Documentation :
//   - https://www.php.net/manual/fr/pdo.connections.php
//   - https://www.php.net/manual/fr/ref.pdo-mysql.connection.php
$pdo = new PDO("mysql:host=$host;port=$port;charset=utf8mb4", $username, $password);

// Création de la base de données si elle n'existe pas
$sql = "CREATE DATABASE IF NOT EXISTS `$database` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;";
$stmt = $pdo->prepare($sql);
$stmt->execute();

// Sélection de la base de données
$sql = "USE `$database`;";
$stmt = $pdo->prepare($sql);
$stmt->execute();

$sql = "CREATE TABLE IF NOT EXISTS food (
    id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(40) NOT NULL,
            peremption DATE NOT NULL,
            shop VARCHAR(20),
            qty FLOAT NOT NULL,
            unit VARCHAR(10) NOT NULL,
            spot VARCHAR(20) NOT NULL
);";

$stmt = $pdo->prepare($sql);

$stmt->execute();

// Gère la soumission du formulaire
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupération des données du formulaire
    $name = $_POST["name"];
    $peremption = $_POST["peremption"];
    $shop = $_POST["shop"];
    $qty = $_POST["qty"];
    $unit = $_POST["unit"];
    $spot = $_POST["spot"];


    $errors = [];

    // à checker

    if (empty($name) || strlen($firstName) < 2) {
        $errors[] = "Le nom de l'aliment doit contenir au moins 2 caractères.";
    }


    if (!empty($shop) && strlen($shop) < 2) {
        $errors[] = "Le nom du magasin doit contenir au moins 2 caractères.";
    }

    if ($qty < 0) {
        $errors[] = "La quantité doit être un nombre positif.";
    }

    // on va ptetre mettre une liste déroulante?
    if (empty($unit)) {
        $errors[] = "La date de péremption est obligatoire.";
    }

    // aussi liste déroulante
    if (empty($spot)) {
        $errors[] = "Un email valide est requis.";
    }


    // Si pas d'erreurs, insertion dans la base de données
    if (empty($errors)) {
        $sql = "INSERT INTO food (name, peremption, shop, qty, unit, spot) VALUES (:name, :peremption, :shop, :qty, :unit, :spot)";

        $sql = "INSERT INTO food (
            name,
            peremption,
            shop,
            qty,
            unit,
            spot
        ) VALUES (
            :peremption,
            :shop,
            :qty,
            :unit,
            :spot
        )";

        // Préparation de la requête SQL
        $stmt = $pdo->prepare($sql);

        // Lien avec les paramètres
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':peremption', $peremption);
        $stmt->bindValue(':shop', $shop);
        $stmt->bindValue(':qty', $qty);
        $stmt->bindValue(':unit', $unit);
        $stmt->bindValue(':spot', $spot);


        $stmt->execute();

        // Redirection vers la page d'accueil avec tous les aliments
        header("Location: index.php");
        exit();
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

    <title>Créer un nouvel aliment | MyApp</title>
</head>

<body>
    <main class="container">
        <h1>Créer un nouvel aliment</h1>

        <?php if ($_SERVER["REQUEST_METHOD"] === "POST") { ?>
            <?php if (empty($errors)) { ?>
                <p style="color: green;">L'aliment a été ajouté avec succès !</p>
            <?php } else { ?>
                <p style="color: red;">Le formulaire contient des erreurs :</p>
                <ul>
                    <?php foreach ($errors as $error) { ?>
                        <li><?php echo $error; ?></li>
                    <?php } ?>
                </ul>
            <?php } ?>
        <?php } ?>

        <!-- à changer -->
        <form action="create.php" method="POST">
            <label for="name">Nom</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($name ?? '') ?>" required minlength="2">

            <label for="peremption">Date de péremption</label>
            <input type="date" id="peremption" name="peremption" value="<?= htmlspecialchars($peremption ?? '') ?>" required>

            <label for="shop">Magasin</label>
            <input type="text" id="shop" name="shop" value="<?= htmlspecialchars($shop ?? '') ?>">

            <label for="qty">Quantité</label>
            <input type="number" id="qty" name="qty" value="<?= htmlspecialchars($qty ?? '') ?>" required min="0">

            <label for="unit">Unité</label>
            <select id="unit" name="unit" required>
                <option value="paquet">paquet</option>
                <option value="ml">mililitre</option>
                <option value="L">litre</option>
                <option value="gr">gramme</option>
                <option value="kilo">kilogramme</option>
            </select>

            <label for="spot">Emplacement</label>
            <select id="spot" name="spot" required>
                <option value="cupboard">Armoire</option>
                <option value="fridge">Réfrigérateur</option>
                <option value="freezer">Congélateur</option>
                <option value="cellar">Cave</option>

            </select>
            <button type="submit">Créer</button>
        </form>
    </main>
</body>

</html>