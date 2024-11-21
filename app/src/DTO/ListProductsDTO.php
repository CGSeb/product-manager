<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class ListProductsDTO
{
    public function __construct(
        #[Assert\Choice(['nameASC', 'nameDESC', 'priceASC', 'priceDESC'])]
        public string $sortType,

        #[Assert\GreaterThan(5)]
        public int $limit,

        public string $q='',
    ){
    }

    public function getOrder(): string
    {
        if (str_ends_with($this->sortType, 'ASC'))
            return 'ASC';

        return 'DESC';
    }

    public function getOrderField(): string
    {
        return str_replace($this->getOrder(), '', $this->sortType);
    }
}