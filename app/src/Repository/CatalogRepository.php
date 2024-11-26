<?php

declare(strict_types=1);

namespace App\Repository;

use App\DTO\ListCatalogsDTO;
use App\Entity\Catalog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Catalog>
 */
class CatalogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Catalog::class);
    }

    /**
     * @return Catalog[]
     */
    public function listCatalogs(ListCatalogsDTO $listCatalogsDTO): array
    {
        $orderField = $listCatalogsDTO->getOrderField();

        $order = 'c.name';
        if ($orderField === 'products') {
            $order = 'counter';
        }

        return $this->createQueryBuilder('c')
            ->addSelect('COUNT(p) AS HIDDEN counter')
            ->where('ILIKE(c.name, :search) = true')
            ->join('c.products', 'p')
            ->setParameter('search', '%'.$listCatalogsDTO->q.'%')
            ->groupBy('c.id')
            ->orderBy($order, $listCatalogsDTO->getOrder())
            ->setMaxResults($listCatalogsDTO->limit)
            ->getQuery()
            ->getResult();
    }
}
