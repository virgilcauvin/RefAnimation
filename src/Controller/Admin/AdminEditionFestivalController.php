<?php

namespace App\Controller\Admin;

use App\Entity\Prix;
use App\Form\PrixType;
use App\Entity\TypeFestival;
use App\Form\TypeFestivalType;
use App\Entity\EditionFestival;
use App\Form\EditionFestivalType;
use App\Repository\PrixRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\TypeFestivalRepository;
use App\Repository\EditionFestivalRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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

    public function __construct(EditionFestivalRepository $repository, TypeFestivalRepository $typeFestRepo, PrixRepository $prixRepo, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->typeFestRepo = $typeFestRepo;
        $this->prixRepo = $prixRepo;
        $this->em = $em;
    }

    /**
     * @Route("/admin/editionFestival", name="admin.editionFestival.index")
     */
    public function index()
    {
        $editionFestivals = $this->repository->findAll();
        return $this->render('admin/editionFestival/index.html.twig', [
            'controller_name' => 'AdminEditionFestivalController',
            'editionFestivals' => $editionFestivals
        ]);
    }

    /**
     * @Route("/admin/editionFestivalLatest", name="admin.editionFestival.latest")
     */
    public function indexLatest()
    {
        $editionFestivals = $this->repository->findLatest();
        return $this->render('admin/editionFestival/index.html.twig', [
            'controller_name' => 'AdminEditionFestivalController',
            'editionFestivals' => $editionFestivals
        ]);
    }

    /**
     * @Route("/admin/editionFestivalOldest", name="admin.editionFestival.oldest")
     */
    public function indexOldest()
    {
        $editionFestivals = $this->repository->findOldest();
        return $this->render('admin/editionFestival/index.html.twig', [
            'controller_name' => 'AdminEditionFestivalController',
            'editionFestivals' => $editionFestivals
        ]);
    }

    /**
     * @Route("/admin/editionFestivalABOrder", name="admin.editionFestival.aBOrder")
     */
    public function indexABOrder()
    {
        $editionFestivals = $this->repository->findByABorder();
        return $this->render('admin/editionFestival/index.html.twig', [
            'controller_name' => 'AdminEditionFestivalController',
            'editionFestivals' => $editionFestivals
        ]);
    }

    /**
     * @Route("/admin/editionFestivalZYOrder", name="admin.editionFestival.zYOrder")
     */
    public function indexZYOrder()
    {
        $editionFestivals = $this->repository->findByZYOrder();
        return $this->render('admin/editionFestival/index.html.twig', [
            'controller_name' => 'AdminEditionFestivalController',
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
            $this->addFlash('success', 'L\'édition de festival a bien été créé !');
            return $this->redirectToRoute('admin.editionFestival.index');
        }

        $typeFestival = new TypeFestival();
        $formTypeFest = $this->createForm(TypeFestivalType::class, $typeFestival);
        $typeFestList = $this->typeFestRepo->findAllDesc();

        $prix = new Prix();
        $formPrix = $this->createForm(PrixType::class, $prix);
        $prixList = $this->prixRepo->findAllDesc();
        
        return $this->render('admin/editionFestival/new.html.twig', [
            'form' => $form->createView(),
            'formTypeFest' => $formTypeFest->createView(),
            'typeFestList' => $typeFestList,
            'formPrix' => $formPrix->createView(),
            'prixList' => $prixList
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

        $typeFestival = new TypeFestival();
        $formTypeFest = $this->createForm(TypeFestivalType::class, $typeFestival);        
        $typeFestList = $this->typeFestRepo->findAllDesc();

        $prix = new Prix();
        $prix->setEditionFestival($editionFestival);
        $formPrix = $this->createForm(PrixType::class, $prix);
        $prixList = $this->prixRepo->findAllDesc();

        return $this->render('admin/editionFestival/edit.html.twig', [
            'editionFestival' => $editionFestival,
            'form' => $form->createView(),
            'formTypeFest' => $formTypeFest->createView(),
            'typeFestList' => $typeFestList,
            'formPrix' => $formPrix->createView(),
            'prixList' => $prixList
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

    /**
     * @Route("/admin/editionFestival/ajouter/ajax", name="admin.editionFestival.ajax")
     */
    public function ajax(EntityManagerInterface $em, Request $request)
    {
        $donnee = $request->request->get('donnee');
        $typeFestival = new TypeFestival();
        $typeFestival->setNom($donnee);
        $em->persist($typeFestival);
        $em->flush();

        $typeFestivalList = $this->typeFestRepo->findAllDesc();

        $typeFestivalTab = [];
        foreach ($typeFestivalList as $typeFestival){
            $typeFestivalTab[$typeFestival->getId()] = $typeFestival->getNom();
        }  
             
        $response = new Response(json_encode($typeFestivalTab));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/admin/editionFestival/ajouter/prixAjax", name="admin.editionFestival.prixAjax")
     */
    public function prixAjax(EntityManagerInterface $em, Request $request)
    {
        $prixNom = $request->request->get('prixNom');
        $prixEdFest = $request->request->get('prixEdFest', );
        $prixFilm = $request->request->get('prixFilm');
        $prix = new Prix();
        $prix->setNom($prixNom);
        $prix->setEditionFestival($prixEdFest);
        $prix->setFilm($prixFilm);
        $em->persist($prix);
        $em->flush();

        $prixList = $this->prixRepo->findAllDesc();

        $prixTab = [];
        foreach ($prixList as $prix){
            $prixTab[$prix->getId()] = $prix->getNom();
        }  
             
        $response = new Response(json_encode($prixTab));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}