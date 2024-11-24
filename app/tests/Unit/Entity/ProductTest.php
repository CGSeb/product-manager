<?php

declare(strict_types=1);

namespace App\Tests\Unit\Entity;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ProductTest extends KernelTestCase
{
    protected EntityManagerInterface $entityManager;

    public function setUp(): void
    {
        parent::setUp();

        $this->entityManager = self::getContainer()->get(EntityManagerInterface::class);
    }

    public function testCreateProduct(): void
    {
        $product = (new Product())
            ->setName('My Product Create')
            ->setPrice(12.62);

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        $this->entityManager->clear();

        $createdProduct = $this->entityManager->getRepository(Product::class)->findOneBy(['name' => 'My Product Create']);

        $this->entityManager->clear();

        self::assertNotNull($createdProduct);

        self::assertEquals(12.62, $createdProduct->getPrice());
        self::assertEquals('My Product Create', $createdProduct->getName());
    }

    public function tearDown(): void
    {
        parent::tearDown();

        restore_exception_handler();
    }
}