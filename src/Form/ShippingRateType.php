<?php
// src/Form/ShippingRateType.php

namespace App\Form;

use App\Entity\ShippingRate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityManagerInterface;

class ShippingRateType extends AbstractType
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('origin', TextType::class, [
                'label' => 'Origin Location',
                'required' => true, 
            ])
            ->add('destination', TextType::class, [
                'label' => 'Destination Location',
                'required' => true, 
            ])
            ->add('weight', NumberType::class, [
                'label' => 'Weight (kg)', 
                'required' => false,
                'attr' => ['placeholder' => 'Enter the weight in kg']
            ])
            ->add('dimensions', TextType::class, [
                'label' => 'Dimensions (cm)',
                'required' => false, 
                'attr' => ['placeholder' => 'Enter dimensions in cm']
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Get Shipping Rates'
            ]);
    }

    private function getShippingZoneChoices()
    {
        // Fetch all shipping zones from the database
        $shippingZones = $this->entityManager->getRepository(ShippingZone::class)->findAll();

        // Map shipping zone objects to an array of key-value pairs (id => name)
        $choices = [];
        foreach ($shippingZones as $zone) {
            $choices[$zone->getShippingZoneName()] = $zone->getId();
        }

        return $choices;
    }
}
