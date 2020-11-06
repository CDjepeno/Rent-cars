<?php

namespace App\Controller;

use App\Entity\Car;
use App\Data\SearchCarData;
use App\Form\SearchCarType;
use App\Repository\CarRepository;
use App\Service\Pagination;
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
    public function index(Pagination $pagination, $page,Request $request, CarRepository $car): Response
    { 

        $data = new SearchCarData();
        $form = $this->createForm(SearchCarType::class,$data);

        $form->handleRequest($request);

        
        if($form->isSubmitted() && $form->isValid()) {
            $cars = $car->findSearch($data);
            // dd($cars);
        }

        $pagination->setEntityClass(Car::class)
                   ->setCurrentPage($page);
        
        
        return $this->render('car/index.html.twig', [
            'pagination' => $pagination,
            'form'       => $form->createView(),
            'cars'        => $cars
        ]);
    }
}
