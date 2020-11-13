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
            ->add("firstName", TextType::class, $this->getConfiguration("votre prenom",'Prénom',"firstname"))
            ->add("lastName", TextType::class, $this->getConfiguration("Votre Nom","Nom","lastname"))
            ->add("email", EmailType::class, $this->getConfiguration("votre email","Email","mail_register"))
            ->add("avatar", UrlType::class, $this->getConfiguration("Votre avatar","URL image","avatar"))
            ->add("hash", PasswordType::class, $this->getConfiguration("Votre mot de passe","password1_register","Tapez votre mot de passe"))
            ->add("passwordConfirm", PasswordType::class, $this->getConfiguration("","password2_register","Re-tapez votre mot de passe"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
