<?php

namespace App\Controller;

use App\Entity\Search;
use App\Form\SearchType;
use App\Repository\FilmRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FilmController extends AbstractController
{

    /**
     * @Var FilmRepository
     */
    private $filmRepository;

    public function __construct(FilmRepository $filmRepository)
    {
        $this->filmRepository = $filmRepository;
    }

    /**
     * @Route("/film", name="film")
     */
    public function index(Request $request)
    {
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);

        $films = $this->filmRepository->findSearch($search);
        //$films = $this->filmRepository->findAll();
        return $this->render('film/film.html.twig', [
            'current_menu' => 'film',
            'films'=> $films,
            /* 'form' => $form-> createView() */
        ]);
    }

    /**
     * @Route("/film/{slug}-{id}", name="film.show", requirements={"slug": "[a-z0-9\-]*"})
     */
    public function show($slug, $id)
    {
        $films = $this->filmRepository->find($id);
        return $this->render('film/show.html.twig', [
            'current_menu' => 'film',
            'films' => $films,

        ]);
    }
}
