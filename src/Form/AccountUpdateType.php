<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccountUpdateType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, $this->getconfiguration("","Modifier votre prénom","firstname"))
            ->add('lastName', TextType::class, $this->getConfiguration("","Modifier votre nom","lastname"))
            ->add('email', EmailType::class, $this->getConfiguration("","Modifier votre email","mail_register"))
            ->add('avatar', UrlType::class, $this->getConfiguration("","Modifier votre image","avatar"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
