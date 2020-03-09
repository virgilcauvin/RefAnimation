<?php

namespace App\Controller\Admin;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminCategorieController extends AbstractController
{

    /**
     * @Var CategorieRepository
     */
    private $repository;

    /**
     * @Var EntityManagerInterface
     */
    private $em;

    public function __construct(CategorieRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/admin/categorie", name="admin.categorie.index")
     */
    public function index()
    {
        $categories = $this->repository->findAll();
        return $this->render('admin/categorie/index.html.twig', [
            'controller_name' => 'AdminCategorieController',
            'categories' => $categories
        ]);
    }

    /**
     *  @Route("/admin/categorie/ajouter", name="admin.categorie.new")
     */
    public function new(Request $request)
    {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($categorie);
            $this->em->flush();
            $this->addFlash('success', 'La catégorie a bien été créé !');
            return $this->redirectToRoute('admin.categorie.index');
        }
        return $this->render('admin/categorie/new.html.twig', [
            'categorie' => $categorie,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/categorie/{id}", name="admin.categorie.edit", methods="GET|POST")
     */
    public function edit(Categorie $categorie, Request $request)
    {
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'La catégorie a bien été modifié !');
            return $this->redirectToRoute('admin.categorie.index');
        }
        return $this->render('admin/categorie/edit.html.twig', [
            'categorie' => $categorie,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/categorie/{id}", name="admin.categorie.delete", methods="DELETE")
     */
    public function delete(Categorie $categorie, Request $request)
    {
            $this->em->remove($categorie);
            $this->em->flush(); 
            $this->addFlash('success', 'La catégorie a bien été supprimé !');
        return $this->redirectToRoute('admin.categorie.index');
    }
}
