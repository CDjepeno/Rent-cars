<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AccountController extends AbstractController
{
    /**
     * Permet de connecter un utilisateur
     * 
     * @Route("/login", name="account_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        return $this->render('account/login.html.twig', [
            "last_username" => $authenticationUtils->getLastUsername(),
            "error"         => $authenticationUtils->getLastAuthenticationError()
        ]);
    }

    /**
     * Permet de déconnecter un utilisateur
     * 
     * @Route("/logout", name="account_logout")
     *
     * @return void
     */
    public function logout() {
        // ..
    }

    /**
     * Permet de d'afficher le compte de l'utilisateur connecter
     * 
     * @Route("/account", name="account_user")
     *
     * @return void
     */
    public function home()
    {
        return $this->render('user/index.html.twig', [
            'user' => $this->getUser()
        ]);
    }
}
