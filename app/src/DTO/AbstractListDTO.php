<?php

declare(strict_types=1);

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

abstract class AbstractListDTO
{
    public function __construct(
        #[Assert\Choice(callback: 'getTypes')]
        public string $sortType,

        #[Assert\GreaterThan(5)]
        public int $limit,

        public string $q = '',
    ) {
    }

    public function getOrder(): string
    {
        if (str_ends_with($this->sortType, 'ASC')) {
            return 'ASC';
        }

        return 'DESC';
    }

    public function getOrderField(): string
    {
        return str_replace($this->getOrder(), '', $this->sortType);
    }
}
