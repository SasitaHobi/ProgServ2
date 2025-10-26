<?php
const DATABASE_CONFIGURATION_FILE = __DIR__ . '/../src/config/database.ini';

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

// Définition de la requête SQL pour récupérer tous les aliments
$sql = "SELECT * FROM food";

$stmt = $pdo->prepare($sql);

$stmt->execute();

$food = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light dark">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">

    <title>Gestion des aliments | MyApp</title>
</head>

<body>
    <main class="container">
        <h1>Gestion des aliments</h1>

        <h2>Liste des aliments</h2>

        <p><a href="create.php"><button>Ajouter un nouvel aliment</button></a></p>

        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Date de péremption</th>
                    <th>Magasin</th>
                    <th>Quantité</th>
                    <th>Unité</th>
                    <th>Emplacement</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($food as $f) { ?>
                    <tr>
                        <td><?= htmlspecialchars($f['name']) ?></td>
                        <td><?= htmlspecialchars($f['peremption']) ?></td>
                        <td><?= htmlspecialchars($f['shop']) ?></td>
                        <td><?= htmlspecialchars($f['qty']) ?></td>
                        <td><?= htmlspecialchars($f['unit']) ?></td>
                        <td><?= htmlspecialchars($f['spot']) ?></td>

                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </main>
</body>

</html>