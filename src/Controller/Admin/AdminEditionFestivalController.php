<?php

namespace App\Controller\Admin;

use App\Entity\Festival;
use App\Entity\EditionFestival;
use App\Form\EditionFestivalType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\EditionFestivalRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminEditionFestivalController extends AbstractController
{

    /**
     * @Var EditionFestivalRepository
     */
    private $repository;

    /**
     * @Var EntityManagerInterface
     */
    private $em;

    public function __construct(EditionFestivalRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/admin/editionFestival", name="admin.editionFestival.index")
     */
    public function index()
    {
        $editionFestivals = $this->repository->findAll();
        return $this->render('admin/editionFestival/index.html.twig', [
            'controller_name' => 'AdmineditionFestivalController',
            'editionFestivals' => $editionFestivals
        ]);
    }

    /**
     *  @Route("/admin/editionFestival/ajouter", name="admin.editionFestival.new")
     */
    public function new(Request $request)
    {
        $editionFestival = new EditionFestival();
        $editionFestival->setUpdatedAt(new \DateTime('now', new \DateTimeZone('Europe/Paris')));
        $form = $this->createForm(EditionFestivalType::class, $editionFestival);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($editionFestival);
            $this->em->flush();
            $this->addFlash('success', 'La catégorie a bien été créé !');
            return $this->redirectToRoute('admin.editionFestival.index');
        }
        return $this->render('admin/editionFestival/new.html.twig', [
            'editionFestival' => $editionFestival,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/editionFestival/{id}", name="admin.editionFestival.edit", methods="GET|POST")
     */
    public function edit(EditionFestival $editionFestival, Request $request, $id)
    {
        $editionFestival = $this->repository->find($id);
        $form = $this->createForm(EditionFestivalType::class, $editionFestival);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $editionFestival->setUpdatedAt(new \DateTime('now', new \DateTimeZone('Europe/Paris')));
            $this->em->flush();
            $this->addFlash('success', 'L\'édition du festival a bien été modifié !');
            return $this->redirectToRoute('admin.editionFestival.index');
        }
        return $this->render('admin/editionFestival/edit.html.twig', [
            'editionFestival' => $editionFestival,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/editionFestival/{id}", name="admin.editionFestival.delete", methods="DELETE")
     */
    public function delete(EditionFestival $editionFestival, Request $request)
    {
            $this->em->remove($editionFestival);
            $this->em->flush(); 
            $this->addFlash('success', 'L\'edition festival a bien été supprimé !');
        return $this->redirectToRoute('admin.editionFestival.index');
    }
}