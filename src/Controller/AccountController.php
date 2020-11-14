<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Booking;
use App\Form\RegistrationType;
use App\Form\AccountUpdateType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountController extends AbstractController
{
    /**
     * Permet de connecter un utilisateur
     * 
     * @Route("/login", name="account_login")
     * 
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        return $this->render('account/login.html.twig', [
            "last_username" => $authenticationUtils->getLastUsername(),
            "error"         => $authenticationUtils->getLastAuthenticationError()
        ]);
    }

    /**
     * Permet d'afficher le formulaire d'inscription
     * 
     * @Route("/register", name="account_register")
     *
     * @return Response
     */
    public function register(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder )
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class,$user);

        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {

            $hash = $encoder->encodePassword($user, $user->getHash());

            $user->setHash($hash);

            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre compte a bien été crée'
            );

            return $this->redirectToRoute('account_login');
        }
        return $this->render('account/registration.html.twig', [
            'form' =>  $form->createView()
        ]);
    }

    /**
     * Permet d'afficher et de gerer le formulaire de modification d'utilisateur
     *
     * @Route("/profile-update", name="account_update")
     * @IsGranted("ROLE_USER")
     * 
     * @param Request $request
     * @param EntityManagerInterface $manager
     * 
     * @return Response
     */    
    public function updateProfile(Request $request, EntityManagerInterface $manager)
    {
        $user = $this->getUser();

        $form = $this->createForm(AccountUpdateType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                "success",
                "Votre compte a été modifié avec succès !"
            );

            return $this->redirectToRoute("account_user");
        }

        return $this->render("account/profileUpdate.html.twig",[
            "form" => $form->createView()
        ]);
    }

    /**
     * Permet de récupérer les reservation de l'utilisateur
     *
     * @Route("/user/bookings/", name="account_user_bookings")
     * @IsGranted("ROLE_USER")
     * 
     * @return Response
     */
    public function bookings() 
    {   
        return $this->render("account/bookings.html.twig");
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
     * @IsGranted("ROLE_USER")
     *
     * @return Response
     */
    public function home()
    {
        return $this->render('user/index.html.twig', [
            'user' => $this->getUser()
        ]);
    }
}
