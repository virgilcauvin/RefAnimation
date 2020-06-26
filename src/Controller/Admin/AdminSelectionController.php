<?php

namespace App\Controller\Admin;

use App\Entity\Selection;
use App\Form\SelectionType;
use App\Repository\SelectionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminSelectionController extends AbstractController
{

    /**
     * @Var SelectionRepository
     */
    private $repository;

    /**
     * @Var EntityManagerInterface
     */
    private $em;

    public function __construct(SelectionRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/admin/selection", name="admin.selection.index")
     */
    public function index()
    {
        $selections = $this->repository->findAll();
        return $this->render('admin/selection/index.html.twig', [
            'controller_name' => 'AdminSelectionController',
            'selections' => $selections
        ]);
    }

    /**
     *  @Route("/admin/selection/ajouter", name="admin.selection.new")
     */
    public function new(Request $request)
    {
        $selection = new Selection();
        $form = $this->createForm(SelectionType::class, $selection);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($selection);
            $this->em->flush();
            $this->addFlash('success', 'La seletion a bien été créé !');
            return $this->redirectToRoute('admin.selection.index');
        }
        return $this->render('admin/selection/new.html.twig', [
            'selection' => $selection,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/selection/{id}", name="admin.selection.edit", methods="GET|POST")
     */
    public function edit(Selection $selection, Request $request)
    {
        $form = $this->createForm(SelectionType::class, $selection);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'La sélection a bien été modifié !');
            return $this->redirectToRoute('admin.selection.index');
        }
        return $this->render('admin/selection/edit.html.twig', [
            'selection' => $selection,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/selection/{id}", name="admin.selection.delete", methods="DELETE")
     */
    public function delete(Selection $selection, Request $request)
    {
            $this->em->remove($selection);
            $this->em->flush(); 
            $this->addFlash('success', 'La sélection a bien été supprimé !');
        return $this->redirectToRoute('admin.selection.index');
    }
}
