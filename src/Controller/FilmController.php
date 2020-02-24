<?php

namespace App\Controller;

use App\Entity\Film;
use App\Repository\FilmRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FilmController extends AbstractController
{

    /**
     * @Var FilmRepository
     */
    private $repository;

    public function __construct(FilmRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/film", name="film")
     */
    public function index()
    {
        $this->repository->findAll();
        return $this->render('film/film.html.twig', [
            'current_menu' => 'properties',
        ]);
    }

    /**
     * @Route("/film/{slug}-{id}", name="film.show", requirements={"slug": "[a-z0-9\-]*"})
     */
    public function show($slug, $id)
    {
        $films = $this->repository->find($id);
        return $this->render('film/show.html.twig', [
            'current_menu' => 'properties',
            'films' => $films
        ]);
    }
}
