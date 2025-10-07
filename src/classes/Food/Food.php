<?php

namespace Foods;

use DateTime;

class Food implements FoodInterface {
    // Propriétés privées pour assurer l'encapsulation
    private ?int $id;
    private string $name;
    private string $group;
    private DateTime $date;
    private string $shop;
    private float $quantity;
    private string $unit;
    private string $spot;

    // Constructeur pour initialiser l'objet
    public function __construct(?int $id, string $name, string $group, DateTime $date, float $quantity, string $unit, ) {
        // Vérification des données
        if (strlen($name) < 2) {
            throw new \InvalidArgumentException("Le nom doit contenir au moins 2 caractères.");
        }

        if (strlen($type) < 2) {
            throw new \InvalidArgumentException("Le type doit contenir au moins 2 caractères.");
        }

        if (!filter_var($price, FILTER_VALIDATE_FLOAT)) {
            throw new \InvalidArgumentException("Un prix valide est requis.");
        } else if ($price < 0) {
            throw new \InvalidArgumentException("Le prix doit être un nombre positif.");
        }


        // Initialisation des propriétés
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->date = $date;
        $this->price = $price;
    }

    // Getters pour accéder aux propriétés
    public function getId(): ?int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getType(): string {
        return $this->type;
    }

    public function getDate(): DateTime {
        return $this->date;
    }

    public function getPrice(): float {
        return $this->price;
    }

    // Setters pour modifier les propriétés
    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function setType(string $type): void {
        $this->type = $type;
    }

    public function setDate(DateTime $date): void {
        $this->date = $date;
    }

    public function setPrice(float $price): void {
        if ($price >= 0) {
            $this->price = $price;
        }
    }
}
