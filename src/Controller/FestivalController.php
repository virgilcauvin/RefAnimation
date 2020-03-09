<?php

namespace App\Controller;

use App\Repository\FestivalRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FestivalController extends AbstractController
{

    /**
     * @Var FestivalRepository
     */
    private $repository;

    public function __construct(FestivalRepository $festivalRepository)
    {
        $this->festivalRepository = $festivalRepository;
    }

    /**
     * @Route("/festival", name="festival")
     */
    public function index()
    {
        $festivals = $this->festivalRepository->findAll();
        return $this->render('festival/festival.html.twig', [
            'current_menu' => 'festival',
            'festivals'=> $festivals
        ]);
    }

    /**
     * @Route("/festival/{slug}-{id}", name="festival.show", requirements={"slug": "[a-z0-9\-]*"})
     */
    public function show($slug, $id)
    {
        $festivals = $this->festivalRepository->find($id);
        return $this->render('festival/show.html.twig', [
            'current_menu' => 'festival',
            'festivals' => $festivals,

        ]);
    }
}
