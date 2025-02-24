<?php
// src/Form/ShippingRateRequestType.php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class ShippingRateRequestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('origin', TextType::class)
            ->add('destination', TextType::class)
            ->add('weight', NumberType::class, [
                'scale' => 2,  // For decimals, set scale to 2 (you can adjust this)
            ])
            ->add('dimensions', TextType::class);
    }
}
