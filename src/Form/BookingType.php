<?php

namespace App\Form;

use App\Entity\Booking;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class BookingType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startDate',DateType::class, $this->getConfiguration(
                "Date de début",
                "Entrez votre date de début",
                ["widget" => "single_text"]))
            ->add('endDate',DateType::class, $this->getConfiguration(
                "Date de fin",
                "Entrez votre date de fin",
                ["widget" => "single_text"]))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
            'csrf_protection' => false
        ]);
    }
}
