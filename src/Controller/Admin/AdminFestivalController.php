<?php

namespace App\Controller\Admin;

use App\Entity\Festival;
use App\Form\FestivalType;
use App\Repository\FestivalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminFestivalController extends AbstractController
{

    /**
     * @Var FestivalRepository
     */
    private $repository;

    /**
     * @Var EntityManagerInterface
     */
    private $em;

    public function __construct(FestivalRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/admin/festival", name="admin.festival.index")
     */
    public function index()
    {
        $festivals = $this->repository->findAll();
        return $this->render('admin/festival/index.html.twig', [
            'controller_name' => 'AdminFestivalController',
            'festivals' => $festivals
        ]);
    }

    /**
     * @Route("/admin/festivalLatest", name="admin.festival.latest")
     */
    public function indexLatest()
    {
        $festivals = $this->repository->findLatest();
        return $this->render('admin/festival/index.html.twig', [
            'controller_name' => 'AdminFestivalController',
            'festivals' => $festivals
        ]);
    }

    /**
     * @Route("/admin/festivalOldest", name="admin.festival.oldest")
     */
    public function indexOldest()
    {
        $festivals = $this->repository->findOldest();
        return $this->render('admin/festival/index.html.twig', [
            'controller_name' => 'AdminFestivalController',
            'festivals' => $festivals
        ]);
    }

    /**
     * @Route("/admin/festivalABOrder", name="admin.festival.aBOrder")
     */
    public function indexABOrder()
    {
        $festivals = $this->repository->findByABorder();
        return $this->render('admin/festival/index.html.twig', [
            'controller_name' => 'AdminfestivalController',
            'festivals' => $festivals
        ]);
    }

    /**
     * @Route("/admin/festivalZYOrder", name="admin.festival.zYOrder")
     */
    public function indexZYOrder()
    {
        $festivals = $this->repository->findByZYOrder();
        return $this->render('admin/festival/index.html.twig', [
            'controller_name' => 'AdminFestivalController',
            'festivals' => $festivals
        ]);
    }

    /**
     *  @Route("/admin/festival/ajouter", name="admin.festival.new")
     */
    public function new(Request $request)
    {
        $festival = new Festival();
        $festival->setUpdated_at(new \DateTime('now', new \DateTimeZone('Europe/Paris')));
        $form = $this->createForm(FestivalType::class, $festival);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($festival);
            $this->em->flush();
            $this->addFlash('success', 'Le festival a bien été créé !');
            return $this->redirectToRoute('admin.festival.index');
        }
        return $this->render('admin/festival/new.html.twig', [
            'festival' => $festival,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/festival/{id}", name="admin.festival.edit", methods="GET|POST")
     */
    public function edit(Festival $festival, Request $request, $id)
    {
        $festival = $this->repository->find($id);
        $form = $this->createForm(FestivalType::class, $festival);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $festival->setUpdated_at(new \DateTime('now', new \DateTimeZone('Europe/Paris')));
            $this->em->flush();
            $this->addFlash('success', 'Le festival a bien été modifié !');
            return $this->redirectToRoute('admin.festival.index');
        }
        return $this->render('admin/festival/edit.html.twig', [
            'festival' => $festival,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/festival/{id}", name="admin.festival.delete", methods="DELETE")
     */
    public function delete(Festival $festival, Request $request)
    {
            $this->em->remove($festival);
            $this->em->flush(); 
            $this->addFlash('success', 'Le festival a bien été supprimé !');
        return $this->redirectToRoute('admin.festival.index');
    }
}