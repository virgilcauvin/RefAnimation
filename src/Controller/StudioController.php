<?php

namespace App\Controller;

use App\Entity\Search;
use App\Form\SearchType;
use App\Repository\StudioRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StudioController extends AbstractController
{
    /**
     * @Var StudioRepository
     */
    private $repository;

    public function __construct(StudioRepository $studioRepository)
    {
        $this->studioRepository = $studioRepository;
    }

    /**
     * @Route("/studio", name="studio")
     */
    public function index(Request $request)
    {
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);

        $studios = $this->studioRepository->findSearch($search);
        return $this->render('studio/studio.html.twig', [
            'current_menu' => 'studio',
            'studios'=> $studios,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/studio/{slug}-{id}", name="studio.show", requirements={"slug": "[a-z0-9\-]*"})
     */
    public function show($slug, $id)
    {
        $studios = $this->studioRepository->find($id);
        return $this->render('studio/show.html.twig', [
            'current_menu' => 'studio',
            'studios' => $studios,

        ]);
    }
}
