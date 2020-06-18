<?php

namespace App\Controller\Admin;

use App\Entity\Studio;
use App\Form\StudioType;
use App\Repository\StudioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminStudioController extends AbstractController
{

    /**
     * @Var StudioRepository
     */
    private $repository;

    /**
     * @Var EntityManagerInterface
     */
    private $em;

    public function __construct(StudioRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/admin/studio", name="admin.studio.index")
     */
    public function index()
    {
        $studios = $this->repository->findAll();
        return $this->render('admin/studio/index.html.twig', [
            'controller_name' => 'AdminstudioController',
            'studios' => $studios
        ]);
    }

    /**
     * @Route("/admin/studioLatest", name="admin.studio.latest")
     */
    public function indexLatest()
    {
        $studios = $this->repository->findLatest();
        return $this->render('admin/studio/index.html.twig', [
            'controller_name' => 'AdminStudioController',
            'studios' => $studios
        ]);
    }

    /**
     * @Route("/admin/studioOldest", name="admin.studio.oldest")
     */
    public function indexOldest()
    {
        $studios = $this->repository->findOldest();
        return $this->render('admin/studio/index.html.twig', [
            'controller_name' => 'AdminStudioController',
            'studios' => $studios
        ]);
    }

    /**
     * @Route("/admin/studioABOrder", name="admin.studio.aBOrder")
     */
    public function indexABOrder()
    {
        $studios = $this->repository->findByABorder();
        return $this->render('admin/studio/index.html.twig', [
            'controller_name' => 'AdminStudioController',
            'studios' => $studios
        ]);
    }

    /**
     * @Route("/admin/studioZYOrder", name="admin.studio.zYOrder")
     */
    public function indexZYOrder()
    {
        $studios = $this->repository->findByZYOrder();
        return $this->render('admin/studio/index.html.twig', [
            'controller_name' => 'AdminStudioController',
            'studios' => $studios
        ]);
    }

    /**
     *  @Route("/admin/studio/ajouter", name="admin.studio.new")
     */
    public function new(Request $request)
    {
        $studio = new Studio();
        $studio->setUpdateAt(new \DateTime('now', new \DateTimeZone('Europe/Paris')));
        $form = $this->createForm(StudioType::class, $studio);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($studio);
            $this->em->flush();
            $this->addFlash('success', 'Le studio a bien été créé !');
            return $this->redirectToRoute('admin.studio.index');
        }
        return $this->render('admin/studio/new.html.twig', [
            'studio' => $studio,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/studio/{id}", name="admin.studio.edit", methods="GET|POST")
     */
    public function edit(Studio $studio, Request $request, $id)
    {
        $festistudioal = $this->repository->find($id);
        $form = $this->createForm(StudioType::class, $studio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $studio->setUpdateAt(new \DateTime('now', new \DateTimeZone('Europe/Paris')));
            $this->em->flush();
            $this->addFlash('success', 'Le studio a bien été modifié !');
            return $this->redirectToRoute('admin.studio.index');
        }
        return $this->render('admin/studio/edit.html.twig', [
            'studio' => $studio,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/studio/{id}", name="admin.studio.delete", methods="DELETE")
     */
    public function delete(Studio $studio, Request $request)
    {
            $this->em->remove($studio);
            $this->em->flush(); 
            $this->addFlash('success', 'Le studio a bien été supprimé !');
        return $this->redirectToRoute('admin.studio.index');
    }
}