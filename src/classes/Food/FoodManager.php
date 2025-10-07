<?php

namespace Food;

require_once __DIR__ . '/../../utils/autoloader.php';

use Database;

class FoodManager implements FoodManagerInterface
{
    private $database;

    public function __construct()
    {
        $this->database = new Database();
    }

    public function getFood(): array
    {
        // Définition de la requête SQL pour récupérer tous les utilisateurs
        $sql = "SELECT * FROM Food";

        // Préparation de la requête SQL
        $stmt = $this->database->getPdo()->prepare($sql);

        // Exécution de la requête SQL
        $stmt->execute();

        // Récupération de tous les utilisateurs
        $Food = $stmt->fetchAll();

        // Transformation des tableaux associatifs en objets User
        $Food = array_map(function ($FoodData) {
            return new Food(
                $FoodData['id'],
                $FoodData['name'],
                $FoodData['type'],
                new \DateTime($FoodData['date']),
                $FoodData['price']
            );
        }, $Food);

        // Retour de tous les utilisateurs
        return $Food;
    }

    public function addFood(Food $Food): int
    {
        // Définition de la requête SQL pour ajouter un utilisateur
        $sql = "INSERT INTO Food (
            name,
            type,
            date,
            price
        ) VALUES (
            :name,
            :type,
            :date,
            :price
        )";

        // Préparation de la requête SQL
        $stmt = $this->database->getPdo()->prepare($sql);

        // Lien avec les paramètres
        $stmt->bindValue(':name', $Food->getName());
        $stmt->bindValue(':type', $Food->getType());
        $stmt->bindValue(':date', $Food->getDate()->format('Y-m-d'));
        $stmt->bindValue(':price', $Food->getPrice());

        // Exécution de la requête SQL pour ajouter un utilisateur
        $stmt->execute();

        // Récupération de l'identifiant de l'utilisateur ajouté
        $FoodId = $this->database->getPdo()->lastInsertId();

        // Retour de l'identifiant de l'utilisateur ajouté.
        return $FoodId;
    }

    public function removeFood(int $id): bool
    {
        // Définition de la requête SQL pour supprimer un utilisateur
        $sql = "DELETE FROM Food WHERE id = :id";

        // Préparation de la requête SQL
        $stmt = $this->database->getPdo()->prepare($sql);

        // Lien avec le paramètre
        $stmt->bindValue(':id', $id);

        // Exécution de la requête SQL pour supprimer un utilisateur
        return $stmt->execute();
    }
}
