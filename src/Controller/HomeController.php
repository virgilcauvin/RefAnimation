<?php

namespace App\Controller;

use App\Repository\FestivalRepository;
use App\Repository\FilmRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(FilmRepository $filmRepository, FestivalRepository $festivalRepository)
    {
        $films = $filmRepository->findLatest();
        $festivals = $festivalRepository->findLatest();
        return $this->render('home/home.html.twig', [
            'controller_name' => 'HomeController',
            'films' => $films,
            'festivals' => $festivals
        ]);
    }
}
