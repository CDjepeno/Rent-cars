<?php

namespace App\Controller;

use App\Entity\Car;
use App\Data\SearchCarData;
use App\Form\CarType;
use App\Form\SearchCarType;
use App\Repository\CarRepository;
use App\Service\Pagination;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CarController extends AbstractController
{
    /**
     * Permet d'afficher les premiers articles sélectionner dans la pagination
     *
     * @Route("/{page<\d+>?1}", name="cars_home")
     */
    public function index(Pagination $pagination, $page, Request $request, CarRepository $car): Response
    {
        $data = new SearchCarData();
        $form = $this->createForm(SearchCarType::class, $data);

        $data->page = $request->get('page', 1);
        
        [$min,$max] = $car->findMinMax($data);
        $form->handleRequest($request);

        $cars = $car->findSearch($data);

        $pagination->setEntityClass(Car::class)
                   ->setCurrentPage($page);
        
        return $this->render('car/index.html.twig', [
            'form'   => $form->createView(),
            'cars'   => $cars,
            'min'    => $min,
            'max'    => $max,
        ]);
    }

    /**
     * Permet de récupérer tous les véhicules d'une catégory
     *
     * @Route("/category/{id}", name="cars_category")
     *
     * @return void
     */
    public function getCarsByCategory(CarRepository $car, $id)
    {
        $cars = $car->getCarsByCategory($id);
       
        return $this->render('car/category.html.twig', [
                  'cars' => $cars
        ]);
    }

    /**
     * Permet à l'utilisateur connecter de crée une annonce
     *
     * @Route("/car/new", name="car_create")
     * 
     * @param Request $request
     * @param EntityManagerInterface $manager
     * 
     * @return Response
     */
    public function create(Request $request, EntityManagerInterface $manager)
    {
        $car = new Car();

        $form = $this->createForm(CarType::class,$car);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $user = $this->getUser();
            $image   = $form->get('image')->getData();
            $fichier = md5(uniqid()).'.'. $image->guessExtension();

            $image->move(
                $this->getParameter('images_directory'),
                $fichier
            );

            $car->setCoverImage($fichier);
            $car->setUser($user);

            $this->addFlash(
                'success',
                'Votre véhicule as bien été ajouter'
            );

            $manager->persist($car);
            $manager->flush();

            return $this->redirectToRoute('account_user');
        }

        return $this->render('car/new.html.twig',[
            "form" => $form->createView()
        ]);
    }

    /**
     * Permet d'afficher la page d'un véhicule
     *
     * @Route("/car/{slug}", name="car_show")
     * 
     * @param Car $car
     * @return Response
     */
    public function show(Car $car) 
    {
        return $this->render('car/show.html.twig', [
            "car" => $car,
        ]);
    }
    
}