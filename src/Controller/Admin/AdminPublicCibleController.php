<?php

namespace App\Controller\Admin;

use App\Entity\PublicCible;
use App\Form\PublicCibleType;
use App\Repository\PublicCibleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminPublicCibleController extends AbstractController
{

    /**
     * @Var PublicCibleRepository
     */
    private $repository;

    /**
     * @Var EntityManagerInterface
     */
    private $em;

    public function __construct(PublicCibleRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/admin/public_cible", name="admin.public_cible.index")
     */
    public function index()
    {
        $public_cibles = $this->repository->findAll();
        return $this->render('admin/public_cible/index.html.twig', [
            'controller_name' => 'AdminPublicCibleController',
            'public_cibles' => $public_cibles
        ]);
    }

    /**
     *  @Route("/admin/public_cible/ajouter", name="admin.public_cible.new")
     */
    public function new(Request $request)
    {
        $public_cible = new PublicCible();
        $form = $this->createForm(PublicCibleType::class, $public_cible);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($public_cible);
            $this->em->flush();
            $this->addFlash('success', 'La catégorie a bien été créé !');
            return $this->redirectToRoute('admin.public_cible.index');
        }
        return $this->render('admin/public_cible/new.html.twig', [
            'public_cible' => $public_cible,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/public_cible/{id}", name="admin.public_cible.edit", methods="GET|POST")
     */
    public function edit(PublicCible $public_cible, Request $request)
    {
        $form = $this->createForm(PublicCibleType::class, $public_cible);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'La catégorie a bien été modifié !');
            return $this->redirectToRoute('admin.public_cible.index');
        }
        return $this->render('admin/public_cible/edit.html.twig', [
            'public_cible' => $public_cible,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/public_cible/{id}", name="admin.public_cible.delete", methods="DELETE")
     */
    public function delete(PublicCible $public_cible, Request $request)
    {
            $this->em->remove($public_cible);
            $this->em->flush(); 
            $this->addFlash('success', 'La catégorie a bien été supprimé !');
        return $this->redirectToRoute('admin.public_cible.index');
    }
}
