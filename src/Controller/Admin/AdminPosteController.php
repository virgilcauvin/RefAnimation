<?php

namespace App\Controller\Admin;

use App\Entity\Poste;
use App\Form\PosteType;
use App\Repository\PosteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminPosteController extends AbstractController
{

    /**
     * @Var PosteRepository
     */
    private $posteRepo;

    /**
     * @Var EntityManagerInterface
     */
    private $em;

    public function __construct(PosteRepository $posteRepo, EntityManagerInterface $em)
    {
        $this->posteRepo = $posteRepo;
        $this->em = $em;
    }

    /**
     * @Route("/admin/poste", name="admin.poste.index")
     */
    public function index()
    {
        $postes = $this->posteRepo->findAll();
        return $this->render('admin/poste/index.html.twig', [
            'controller_name' => 'AdminPosteController',
            'postes' => $postes
        ]);
    }

    /**
     * @Route("/admin/posteABOrder", name="admin.poste.aBOrder")
     */
    public function indexABOrder()
    {
        $postes = $this->repository->findByABorder();
        return $this->render('admin/poste/index.html.twig', [
            'controller_name' => 'poste',
            'postes' => $postes
        ]);
    }

    /**
     * @Route("/admin/posteZYOrder", name="admin.poste.zYOrder")
     */
    public function indexZYOrder()
    {
        $postes = $this->repository->findByZYOrder();
        return $this->render('admin/poste/index.html.twig', [
            'controller_name' => 'AdminPosteController',
            'postes' => $postes
        ]);
    }

    /**
     *  @Route("/admin/poste/ajouter", name="admin.poste.new")
     */
    public function new(Request $request)
    {
        $poste = new Poste();
        /* $poste->setUpdateAt(new \DateTime('now', new \DateTimeZone('Europe/Paris'))); */
        $form = $this->createForm(PosteType::class, $poste);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($poste);
            $this->em->flush();
            $this->addFlash('success', 'Le poste a bien été créé !');
            return $this->redirectToRoute('admin.poste.index');
        }
        return $this->render('admin/poste/new.html.twig', [
            'poste' => $poste,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/poste/{id}", name="admin.poste.edit", methods="GET|POST")
     */
    public function edit(Poste $poste, Request $request, $id)
    {
        $poste = $this->posteRepo->find($id);
        $form = $this->createForm(PosteType::class, $poste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /* $poste->setUpdateAt(new \DateTime('now', new \DateTimeZone('Europe/Paris'))); */
            $this->em->flush();
            $this->addFlash('success', 'Le poste a bien été modifié !');
            return $this->redirectToRoute('admin.poste.index');
        }
        return $this->render('admin/poste/edit.html.twig', [
            'poste' => $poste,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/poste/{id}", name="admin.poste.delete", methods="DELETE")
     */
    public function delete(Poste $poste, Request $request)
    {
            $this->em->remove($poste);
            $this->em->flush(); 
            $this->addFlash('success', 'Le poste a bien été supprimé !');
        return $this->redirectToRoute('admin.poste.index');
    }
}
