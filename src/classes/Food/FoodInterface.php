<?php

namespace Tools;

use DateTime;

interface ToolsInterface {
    public function getId(): ?int;
    public function getName(): string;
    public function getType(): string;
    public function getDate(): DateTime;
    public function getPrice(): float;

    public function setId(int $id): void;
    public function setName(string $name): void;
    public function setType(string $type): void;
    public function setDate(DateTime $date): void;
    public function setPrice(float $price): void;
}
