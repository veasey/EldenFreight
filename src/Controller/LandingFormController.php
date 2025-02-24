<?php

// src/Controller/DefaultController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ShippingService;

class LandingFormController extends AbstractController
{
    public function __construct(ShippingService $shippingService)
    {
        $this->shippingService = $shippingService;
    }

    #[Route('/', name: 'app_homepage')]
    public function index(): Response
    {
        return $this->render('shipping_rates/form.html.twig');
    }

    #[Route('/submit', name: 'app_shipping_get_rates')]
    public function getShippingRates(Request $request): Response
    {
        $form = $this->createForm(ShippingRateRequestType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            // Call the shipping rate service
            $shippingRates = $this->shippingRateService->getRates(
                $data['origin'],
                $data['destination'],
                $data['weight'],
                $data['dimensions']
            );

            return $this->render('shipping/rate.html.twig', [
                'shippingRates' => $shippingRates,
            ]);
        }

        return $this->render('shipping_rates/results.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
