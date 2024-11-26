<?php

declare(strict_types=1);

namespace App\DTO;

class ListCatalogsDTO extends AbstractListDTO
{
    /**
     * @return array<string>
     */
    public static function getTypes(): array
    {
        return ['nameASC', 'nameDESC', 'productsASC', 'productsDESC'];
    }
}
