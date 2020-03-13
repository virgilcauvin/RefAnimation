<?php

namespace App\Controller\Admin;

use App\Entity\Prix;
use App\Form\PrixType;
use App\Repository\PrixRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminPrixController extends AbstractController
{

    /**
     * @Var PrixRepository
     */
    private $repository;

    /**
     * @Var EntityManagerInterface
     */
    private $em;

    public function __construct(PrixRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/admin/prix", name="admin.prix.index")
     */
    public function index()
    {
        $prixs = $this->repository->findAll();
        return $this->render('admin/prix/index.html.twig', [
            'controller_name' => 'AdminPrixController',
            'prixs' => $prixs
        ]);
    }

    /**
     *  @Route("/admin/prix/ajouter", name="admin.prix.new")
     */
    public function new(Request $request)
    {
        $prix = new Prix();
        $form = $this->createForm(PrixType::class, $prix);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($prix);
            $this->em->flush();
            $this->addFlash('success', 'Le prix a bien été créé !');
            return $this->redirectToRoute('admin.prix.index');
        }
        return $this->render('admin/prix/new.html.twig', [
            'prix' => $prix,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/prix/{id}", name="admin.prix.edit", methods="GET|POST")
     */
    public function edit(Prix $prix, Request $request)
    {
        $form = $this->createForm(PrixType::class, $prix);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'Le prix a bien été modifié !');
            return $this->redirectToRoute('admin.prix.index');
        }
        return $this->render('admin/prix/edit.html.twig', [
            'prix' => $prix,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/prix/{id}", name="admin.prix.delete", methods="DELETE")
     */
    public function delete(Prix $prix, Request $request)
    {
            $this->em->remove($prix);
            $this->em->flush(); 
            $this->addFlash('success', 'Le prix a bien été supprimé !');
        return $this->redirectToRoute('admin.prix.index');
    }
}
