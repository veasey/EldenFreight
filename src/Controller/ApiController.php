<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\ShippingService;

final class ApiController extends AbstractController
{
    private ShippingService $shippingService;

    public function __construct(ShippingService $shippingService)
    {
        $this->shippingService = $shippingService;
    }

    #[Route('/api/health', name: 'app_shipping')]
    public function health(): JsonResponse
    {
        return $this->json([
            'status' => 'OK'
        ]);
    }

    #[Route('/api/shipping-rates', name: 'shipping_rates', methods: ['POST'])]
    public function getShippingRates(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['origin'], $data['destination'], $data['weight'])) {
            return $this->json(['error' => 'Missing required fields'], 400);
        }

        $rates = $this->shippingService->getShippingRates($data);

        return $this->json($rates);
    }
}
