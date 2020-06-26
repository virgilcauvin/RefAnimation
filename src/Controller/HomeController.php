<?php

namespace App\Controller;

use App\Entity\Search;
use App\Form\SearchType;
use App\Repository\CategorieRepository;
use App\Repository\FilmRepository;
use App\Repository\FestivalRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{

    public function __construct(FilmRepository $filmRepository, FestivalRepository $festivalRepo)
    {
        $this->filmRepository = $filmRepository;
        $this->festivalRepo = $festivalRepo;

    }

    /**
     * @Route("/", name="home")
     */
    public function index(Request $request)
    {
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);
        $films = $this->filmRepository->findSearch($search);
        $festivals = $this->festivalRepo->findSearch($search);

        return $this->render('home/home.html.twig', [
            'controller_name' => 'HomeController',
            'form' => $form->createView(),
            'films' => $films,
            'festivals' => $festivals,
        ]);
    }

}
