<?php

namespace App\Controller;

use App\Repository\FilmRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(FilmRepository $repository)
    {
        $films = $repository->findLatest();
        return $this->render('home/home.html.twig', [
            'controller_name' => 'HomeController',
            'films' => $films
        ]);
    }
}
