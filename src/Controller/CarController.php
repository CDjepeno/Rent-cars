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

        $data->page = $request->get('page',1);
        
        [$min,$max] = $car->findMinMax($data);
        $form->handleRequest($request);

        $cars = $car->Search($data);


        $pagination->setEntityClass(Car::class)
                   ->setCurrentPage($page);
        
        
        return $this->render('.twig', [
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
    public function getCarsByCategory(CarRepository $car, $id) {

        $cars = $car->getCarsByCategory($id);
       
        return $this->render('car/category.html.twig',[
                  'cars' => $cars,
            'pagination' => $pagination,
            'form'       => $form->createView(),
        ]