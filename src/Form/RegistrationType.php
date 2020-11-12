<?php

namespace App\Form;

use App\Entity\User;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationType extends ApplicationType
{
  

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, $this->getConfiguration("votre prenom",'Prénom', ["required" => true]))
            ->add('lastName', TextType::class, $this->getConfiguration('Votre Nom','Nom', ["required" => true]))
            ->add('email', EmailType::class, $this->getConfiguration('Votre email','Email',["required" => true]))
            ->add('avatar', UrlType::class, $this->getConfiguration('Votre avatar','URL image',["required" => true]))
            ->add('hash', PasswordType::class, $this->getConfiguration('Votre mot de passe','Tapez votre mot de passe'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
