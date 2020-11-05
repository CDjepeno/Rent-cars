<?php

namespace App\Controller;

use App\Repository\CarRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CarController extends AbstractController
{
    /**
     * @Route("/{page<\d+>?1}", name="cars_home")
     */
    public function index(CarRepository $car, $page): Response
    { 
        $limit = 6;

        $start = $page * $limit - $limit;

        $total = count($car->findAll());

        $pages = ceil($total / $limit);

        return $this->render('car/index.html.twig', [
            'cars' => $car->findBy([],[],$limit,$start),
            'page' => $page,
            'pages' => $pages
        ]);
    }
}
