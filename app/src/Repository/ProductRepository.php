<?php

declare(strict_types=1);

namespace App\Repository;

use App\DTO\ListProductsDTO;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * @return Product[]
     */
    public function listProducts(ListProductsDTO $listProductsDTO): array
    {
        $queryBuilder = $this->createQueryBuilder('p')
            ->leftjoin('p.catalog', 'c')
            ->where('ILIKE(p.name, :search) = true')
            ->setParameter('search', '%'.$listProductsDTO->q.'%');

        if (!empty($listProductsDTO->catalogs)) {
            $queryBuilder
                ->andWhere('c.id IN (:catalogIds)')
                ->setParameter('catalogIds', $listProductsDTO->catalogs);
        }

        return $queryBuilder
            ->orderBy('p.'.$listProductsDTO->getOrderField(), $listProductsDTO->getOrder())
            ->setMaxResults($listProductsDTO->limit)
            ->getQuery()
            ->getResult();
    }
}
