<?php

namespace App\Controller;

use App\Repository\EditionFestivalRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EditionFestivalController extends AbstractController
{
    /**
     * @Var EditionFestivalRepository
     */
    private $repository;

    public function __construct(EditionFestivalRepository $editionFestivalRepository)
    {
        $this->editionFestivalRepository = $editionFestivalRepository;
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
