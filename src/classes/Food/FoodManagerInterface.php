<?php

namespace Food;

interface FoodManagerInterface {
    public function getFood(): array;
    public function addFood(Food $Food): int;
    public function removeFood(int $id): bool;
}
