<?php

namespace App\Controller;

use App\Repository\StudioRepository;
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
    public function index()
    {
        $studios = $this->studioRepository->findAll();
        return $this->render('studio/studio.html.twig', [
            'current_menu' => 'studio',
            'studios'=> $studios
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
