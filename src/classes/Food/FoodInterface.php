<?php

namespace Food;

use DateTime;

interface FoodInterface {
    public function getId(): ?int;
    public function getName(): string;
    public function getPeremption(): DateTime;
    public function getShop(): string;
    public function getQuantity(): float;
    public function getUnit(): string;
    public function getSpot(): string;

    public function setId(int $id): void;
    public function setName(string $name): void;
    public function setPeremption(DateTime $peremption): void;
    public function setShop(string $shop): void;
    public function setQuantity(float $qty): void;
    public function setUnit(string $unit): void;
    public function setSpot(string $spot): void;
}
