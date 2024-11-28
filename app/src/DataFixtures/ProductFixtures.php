<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $products = [
            ['name' => 'Product 03', 'price' => 7.99],
            ['name' => 'Product 10', 'price' => 2.49],
            ['name' => 'Product 11', 'price' => 11.00],
            ['name' => 'Product 07', 'price' => 3.99],
            ['name' => 'Product 02', 'price' => 5.49],
            ['name' => 'Product 12', 'price' => 29.99],
            ['name' => 'Product 08', 'price' => 8.25],
            ['name' => 'Product 13', 'price' => 18.75],
            ['name' => 'Product 05', 'price' => 23.50],
            ['name' => 'Product 01', 'price' => 10.99],
            ['name' => 'Product 09', 'price' => 19.99],
            ['name' => 'Product 06', 'price' => 12.75],
            ['name' => 'Product 04', 'price' => 15.99],
        ];

        foreach ($products as $productData) {
            $product = (new Product())
                ->setName($productData['name'])
                ->setPrice($productData['price']);
            $manager->persist($product);
        }

        $manager->flush();
    }
}
