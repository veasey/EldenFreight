<?php

// src/Controller/DefaultController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ShippingService;
use App\Form\ShippingRateType;

class LandingFormController extends AbstractController
{
    private ShippingService $shippingService;

    public function __construct(ShippingService $shippingService)
    {
        $this->shippingService = $shippingService;
    }

    #[Route('/', name: 'app_homepage')]
    public function index(): Response
    {
        $form = $this->createForm(ShippingRateType::class);

        return $this->render('shipping_rates/form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/shipping-rates', name: 'app_shipping_get_rates')]
    public function getShippingRates(Request $request): Response
    {
        $form = $this->createForm(ShippingRateType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            // Call the shipping rate service
            $shippingRates = $this->shippingService->getShippingRates($data);

            return $this->render('shipping_rates/results.html.twig', [
                'shippingRates' => $shippingRates,
            ]);
        }

        return $this->render('shipping_rates/form.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
