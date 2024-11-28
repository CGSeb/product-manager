<?php

declare(strict_types=1);

namespace App\DTO;

class ListProductsDTO extends AbstractListDTO
{
    /** @param array<int> $catalogs */
    public function __construct(
        string $sortType,
        int $limit,
        string $q = '',
        public array $catalogs = [],
    ) {
        parent::__construct($sortType, $limit, $q);
    }

    /**
     * @return array<string>
     */
    public static function getTypes(): array
    {
        return ['nameASC', 'nameDESC', 'priceASC', 'priceDESC'];
    }
}
