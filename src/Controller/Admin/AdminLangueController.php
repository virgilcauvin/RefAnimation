<?php

namespace App\Controller\Admin;

use App\Entity\Langue;
use App\Form\LangueType;
use App\Repository\LangueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminLangueController extends AbstractController
{

    /**
     * @Var LangueRepository
     */
    private $repository;

    /**
     * @Var EntityManagerInterface
     */
    private $em;

    public function __construct(LangueRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/admin/langue", name="admin.langue.index")
     */
    public function index()
    {
        $langues = $this->repository->findAll();
        return $this->render('admin/langue/index.html.twig', [
            'controller_name' => 'AdminLangueController',
            'langues' => $langues
        ]);
    }

    /**
     *  @Route("/admin/langue/ajouter", name="admin.langue.new")
     */
    public function new(Request $request)
    {
        $langue = new Langue();
        $form = $this->createForm(LangueType::class, $langue);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($langue);
            $this->em->flush();
            $this->addFlash('success', 'La catégorie a bien été créé !');
            return $this->redirectToRoute('admin.langue.index');
        }
        return $this->render('admin/langue/new.html.twig', [
            'langue' => $langue,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/langue/{id}", name="admin.langue.edit", methods="GET|POST")
     */
    public function edit(Langue $langue, Request $request)
    {
        $form = $this->createForm(LangueType::class, $langue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'La catégorie a bien été modifié !');
            return $this->redirectToRoute('admin.langue.index');
        }
        return $this->render('admin/langue/edit.html.twig', [
            'langue' => $langue,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/langue/{id}", name="admin.langue.delete", methods="DELETE")
     */
    public function delete(Langue $langue, Request $request)
    {
            $this->em->remove($langue);
            $this->em->flush(); 
            $this->addFlash('success', 'La catégorie a bien été supprimé !');
        return $this->redirectToRoute('admin.langue.index');
    }
}
