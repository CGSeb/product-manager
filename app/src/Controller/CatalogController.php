<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\CatalogDTO;
use App\Entity\Catalog;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/catalog')]
class CatalogController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private SerializerInterface $serializer,
        private ProductRepository $productRepository,
    ) {
    }

    #[Route('', name: 'app_catalog_create', methods: [Request::METHOD_POST])]
    public function create(
        #[MapRequestPayload] CatalogDTO $catalogDTO,
    ): JsonResponse {
        $catalog = (new Catalog())
            ->setName($catalogDTO->name);

        foreach($catalogDTO->products as $productId) {
            $product = $this->productRepository->find($productId);
            if($product ===null) {
                throw new BadRequestHttpException(
                    message: sprintf("Product with id '%s' not found", $productId),
                    code: Response::HTTP_BAD_REQUEST,
                );
            }

            $catalog->addProduct($product);
        }

        $this->entityManager->persist($catalog);
        $this->entityManager->flush();

        return new JsonResponse(
            data: $this->serializer->serialize($catalog, 'json', ['groups'=> ['single']]),
            json: true,
        );
    }
}
