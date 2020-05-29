<?php

namespace App\Controller;

use App\Entity\Search;
use App\Form\SearchType;
use App\Repository\FilmRepository;
use App\Repository\FestivalRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{

    public function __construct(FilmRepository $filmRepository)
    {
        $this->filmRepository = $filmRepository;
    }

    /**
     * @Route("/", name="home")
     */
    public function index(FestivalRepository $festivalRepository, Request $request)
    {
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);
        $films = $this->filmRepository->findSearch($search);
        $festivals = $festivalRepository->findSearch($search);

        $texte = $request->query->get('byText', " Aucune recherche");
        $publicCible = $request->query->get('byPublicCible', " Aucun public cible");
        

        /* $films = $filmRepository->findLatest();
            $festivals = $festivalRepository->findLatest(); */
        return $this->render('home/home.html.twig', [
            'controller_name' => 'HomeController',
            'films' => $films,
            'festivals' => $festivals,
            'texte' => $texte,
            'publicCible' => $publicCible
        ]);
    }

    /**
     * Function pour le template base.html.twig
     */
    public function searchBase(Request $request)
    {
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);

        

        return $this->render('base/searchBase.html.twig', [
            'form' => $form->createView(),
            
        ]);
    }
}
