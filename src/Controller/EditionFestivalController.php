<?php

namespace App\Controller;

use App\Repository\EditionFestivalRepository;
use App\Repository\FestivalRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EditionFestivalController extends AbstractController
{
    /**
     * @Var EditionFestivalRepository
     */
    private $repository;

    public function __construct(EditionFestivalRepository $editionFestivalRepository, FestivalRepository $festivalRepository)
    {
        $this->editionFestivalRepository = $editionFestivalRepository;
        $this->festivalRepository = $festivalRepository;
    }

    /**
     * @Route("/editionFestival", name="editionFestival")
     */
    public function index()
    {
        $editionFestivals = $this->editionFestivalRepository->findAll();
        return $this->render('editionFestival/editionFestival.html.twig', [
            'current_menu' => 'editionFestival',
            'editionFestivals'=> $editionFestivals
        ]);
    }

    /**
     * @Route("/editionFestival/{slug}-{id}", name="editionFestival.show", requirements={"slug": "[a-z0-9\-]*"})
     */
    public function show($slug, $id)
    {
        $editionFestivals = $this->editionFestivalRepository->find($id);
        return $this->render('editionFestival/show.html.twig', [
            'current_menu' => 'editionFestival',
            'editionFestivals' => $editionFestivals,

        ]);
    }
}
