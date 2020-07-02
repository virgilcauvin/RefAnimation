<?php

namespace App\Controller\Admin;

use App\Entity\Poste;
use App\Form\PosteType;
use App\Entity\Technicien;
use App\Form\TechnicienType;
use App\Repository\FilmRepository;
use App\Repository\PosteRepository;
use App\Repository\TechnicienRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminTechnicienController extends AbstractController
{

    /**
     * @Var TechnicienRepository
     */
    private $techRepo;

    /**
     * @Var EntityManagerInterface
     */
    private $em;

    public function __construct(TechnicienRepository $TechRepo, PosteRepository $posteRepo, FilmRepository $filmRepo, EntityManagerInterface $em)
    {
        $this->techRepo = $TechRepo;
        $this->posteRepo = $posteRepo;
        $this->filmRepo = $filmRepo;
        $this->em = $em;
    }

    /**
     * @Route("/admin/technicien", name="admin.technicien.index")
     */
    public function index()
    {
        $techs = $this->techRepo->findAll();
        return $this->render('admin/technicien/index.html.twig', [
            'controller_name' => 'AdminTechnicienController',
            'techs' => $techs
        ]);
    }

    /**
     * @Route("/admin/technicienABOrder", name="admin.technicien.aBOrder")
     */
    public function indexABOrder()
    {
        $techs = $this->repository->findByABorder();
        return $this->render('admin/technicien/index.html.twig', [
            'controller_name' => 'technicien',
            'techs' => $techs
        ]);
    }

    /**
     * @Route("/admin/technicienZYOrder", name="admin.technicien.zYOrder")
     */
    public function indexZYOrder()
    {
        $techs = $this->repository->findByZYOrder();
        return $this->render('admin/technicien/index.html.twig', [
            'controller_name' => 'technicien',
            'techs' => $techs
        ]);
    }

    /**
     *  @Route("/admin/technicien/ajouter", name="admin.technicien.new")
     */
    public function new(Request $request)
    {
        $tech = new Technicien();
        /* $tech->setUpdateAt(new \DateTime('now', new \DateTimeZone('Europe/Paris'))); */
        $form = $this->createForm(TechnicienType::class, $tech);
        $form->handleRequest($request);
        
        
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($tech);
            $this->em->flush();
            $this->addFlash('success', 'Le technicien a bien été créé !');
            return $this->redirectToRoute('admin.technicien.index');
        }

        $poste = new Poste();
        $formPoste = $this->createForm(PosteType::class, $poste);
        $posteList = $this->posteRepo->findAllDesc();

        return $this->render('admin/technicien/new.html.twig', [
            'tech' => $tech,
            'form' => $form->createView(),
            'formPoste' => $formPoste->createView(),
            'posteList' => $posteList
        ]);
    }

    /**
     * @Route("/admin/technicien/{id}", name="admin.technicien.edit", methods="GET|POST")
     */
    public function edit(Technicien $tech, Request $request, $id)
    {
        $tech = $this->techRepo->find($id);
        $form = $this->createForm(TechnicienType::class, $tech);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /* $tech->setUpdateAt(new \DateTime('now', new \DateTimeZone('Europe/Paris'))); */
            $this->em->persist($tech);
            $this->em->flush();
            $this->addFlash('success', 'Le technicien a bien été modifié !');
            return $this->redirectToRoute('admin.technicien.index');
        }

        $poste = new Poste();
        $formPoste = $this->createForm(PosteType::class, $poste);
        $posteList = $this->posteRepo->findAllDesc();

        return $this->render('admin/technicien/edit.html.twig', [
            'tech' => $tech,
            'form' => $form->createView(),
            'formPoste' => $formPoste->createView(),
            'posteList' => $posteList
        ]);
    }

    /**
     * @Route("/admin/technicien/{id}", name="admin.technicien.delete", methods="DELETE")
     */
    public function delete(Technicien $tech, Request $request)
    {
            $this->em->remove($tech);
            $this->em->flush(); 
            $this->addFlash('success', 'Le technicien a bien été supprimé !');
        return $this->redirectToRoute('admin.technicien.index');
    }

    /**
     * @Route("/admin/technicien/ajouter/posteAjax", name="admin.technicien.posteAjax")
     */
    public function posteAjax(EntityManagerInterface $em, Request $request)
    {
        $posteNom = $request->request->get('posteNom');
        $posteFilm = $request->request->get('posteFilm');
        $film = $this->filmRepo->find($posteFilm);
        $poste = new Poste();
        $poste->setNom($posteNom);
        $poste->setFilm($film);
        $em->persist($poste);
        $em->flush();

        $posteList = $this->posteRepo->findAllDesc();

        $posteTab = [];
        foreach ($posteList as $poste){
            $posteTab[$poste->getId()] = $poste->getNom() . " - " . $poste->getFilm()->getNom();

        }  
             
        $response = new Response(json_encode($posteTab));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
