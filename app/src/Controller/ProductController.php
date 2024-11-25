<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\ListProductsDTO;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/product')]
class ProductController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private SerializerInterface $serializer,
        private ProductRepository $productRepository,
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

    #[Route('', name: 'app_product_list', methods: [Request::METHOD_GET])]
    public function list(
        #[MapQueryString] ListProductsDTO $listProductsDTO,
    ): JsonResponse {
        $products = $this->productRepository->listProducts($listProductsDTO);

        return new JsonResponse(
            data: $this->serializer->serialize($products, 'json', ['groups' => ['list']]),
            json: true
        );
    }
}
