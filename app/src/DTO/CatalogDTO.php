<?php

declare(strict_types=1);

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class CatalogDTO
{
    /**
     * @param array<int> $products
     */
    public function __construct(
        #[Assert\NotBlank]
        public string $name,

        #[Assert\NotBlank(message: 'This value should not be empty.')]
        public array $products,
    ) {
    }
}
