<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/product')]
class ProductController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private SerializerInterface $serializer,
    ) {
    }

    #[Route('', name: 'app_product_create', methods: [Request::METHOD_POST])]
    public function create(
        #[MapRequestPayload] Product $product,
    ): JsonResponse {
        $this->entityManager->persist($product);
        $this->entityManager->flush();

        return new JsonResponse(
            $this->serializer->serialize($product, 'json'),
        );
    }
}