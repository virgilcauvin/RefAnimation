<?php

namespace App\Controller\Admin;

use App\Entity\TypeFestival;
use App\Form\TypeFestivalType;
use App\Repository\TypeFestivalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminTypeFestivalController extends AbstractController
{

    /**
     * @Var TypeFestivalRepository
     */
    private $repository;

    /**
     * @Var EntityManagerInterface
     */
    private $em;

    public function __construct(TypeFestivalRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/admin/typeFestival", name="admin.typeFestival.index")
     */
    public function index()
    {
        $typeFestivals = $this->repository->findAll();
        return $this->render('admin/typeFestival/index.html.twig', [
            'controller_name' => 'AdminTypeFestivalController',
            'typeFestivals' => $typeFestivals
        ]);
    }

    /**
     *  @Route("/admin/typeFestival/ajouter", name="admin.typeFestival.new")
     */
    public function new(Request $request)
    {
        $typeFestival = new TypeFestival();
        $form = $this->createForm(TypeFestivalType::class, $typeFestival);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($typeFestival);
            $this->em->flush();
            $this->addFlash('success', 'Le type de festival a bien été créé !');
            return $this->redirectToRoute('admin.typeFestival.index');
        }
        return $this->render('admin/typeFestival/new.html.twig', [
            'typeFestival' => $typeFestival,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/typeFestival/{id}", name="admin.typeFestival.edit", methods="GET|POST")
     */
    public function edit(TypeFestival $typeFestival, Request $request)
    {
        $form = $this->createForm(TypeFestivalType::class, $typeFestival);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'Le type de festival a bien été modifié !');
            return $this->redirectToRoute('admin.typeFestival.index');
        }
        return $this->render('admin/typeFestival/edit.html.twig', [
            'typeFestival' => $typeFestival,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/typeFestival/{id}", name="admin.typeFestival.delete", methods="DELETE")
     */
    public function delete(TypeFestival $typeFestival, Request $request)
    {
            $this->em->remove($typeFestival);
            $this->em->flush(); 
            $this->addFlash('success', 'La catégorie a bien été supprimé !');
        return $this->redirectToRoute('admin.typeFestival.index');
    }
}
