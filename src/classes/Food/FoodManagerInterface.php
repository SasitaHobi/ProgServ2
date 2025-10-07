<?php

namespace Foods;

interface FoodsManagerInterface {
    public function getFoods(): array;
    public function addFood(Food $Food): int;
    public function removeFood(int $id): bool;
}
