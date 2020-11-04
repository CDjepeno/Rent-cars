<?php

namespace App\Controller;

use App\Repository\CarRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CarController extends AbstractController
{
    /**
     * @Route("/", name="cars_home")
     */
    public function index(CarRepository $car): Response
    { 
        return $this->render('car/index.html.twig', [
            'cars' => $car->findAll()
        ]);
    }
}
