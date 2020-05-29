<?php

namespace App\Controller;

use App\Entity\Search;
use App\Form\SearchType;
use App\Repository\FestivalRepository;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FestivalController extends AbstractController
{

    /**
     * @Var FestivalRepository
     */
    private $festivalRepository;

    public function __construct(FestivalRepository $festivalRepository)
    {
        $this->festivalRepository = $festivalRepository;
    }

    /**
     * @Route("/festival", name="festival")
     */
    public function index(Request $request)
    {
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);

        $festivals = $this->festivalRepository->findSearch($search);
        /* $festivals = $this->festivalRepository->findAll(); */
        return $this->render('festival/festival.html.twig', [
            'current_menu' => 'festival',
            'festivals'=> $festivals,
            /* 'form' => $form-> createView() */
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
