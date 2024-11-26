<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Catalog;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CatalogFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $catalogs = [
            [
                'name' => 'Catalog 01',
                'products' => [1, 2],
            ],
            [
                'name' => 'Catalog 02',
                'products' => [3, 4, 5],
            ],
            [
                'name' => 'Catalog 03',
                'products' => [6],
            ],
            [
                'name' => 'Catalog 33',
                'products' => [7],
            ],
        ];

        shuffle($catalogs);

        foreach ($catalogs as $catalogData) {
            $catalog = (new Catalog())
                ->setName($catalogData['name']);

            foreach ($catalogData['products'] as $productId) {
                $product = $manager->getRepository(Product::class)->find($productId);
                $catalog->addProduct($product);
            }

            $manager->persist($catalog);
        }

        $manager->flush();
    }

    /**
     * @return list<class-string<Fixture>>
     */
    public function getDependencies(): array
    {
        return [ProductFixtures::class];
    }
}
