<?php

namespace App\Integrations\Ecom;

use Spatie\LaravelData\Data;

class Product extends Data
{
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly float $price,
        public readonly ?string $description,
        public readonly ?string $image,
    ) {}
}
