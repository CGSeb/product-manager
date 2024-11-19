<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api')]
class HomeController
{
    #[Route('/', name: 'app_home')]
    public function number(): JsonResponse
    {
        $number = random_int(0, 100);

        return new JsonResponse(
            ["number" => $number],
        );
    }
}