<?php

namespace App\Controller\Admin;

use App\Entity\Film;
use App\Entity\Langue;
use App\Form\FilmType;
use App\Form\LangueType;
use App\Repository\FilmRepository;
use App\Repository\LangueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminFilmController extends AbstractController
{

    /**
     * @Var FilmRepository
     */
    private $FilmRepo;

    /**
     * @Var EntityManagerInterface
     */
    private $em;


    public function __construct(FilmRepository $FilmRepo, LangueRepository $langueRepo, EntityManagerInterface $em)
    {
        $this->FilmRepo = $FilmRepo;
        $this->langueRepo = $langueRepo;
        $this->em = $em;
    }

    /**
     * @Route("/admin/film", name="admin.film.index")
     */
    public function index()
    {
        $films = $this->FilmRepo->findAll();
        return $this->render('admin/film/index.html.twig', [
            'controller_name' => 'AdminFilmController',
            'films' => $films
        ]);
    }

    /**
     * @Route("/admin/filmLatest", name="admin.film.latest")
     */
    public function indexLatest()
    {
        $films = $this->FilmRepo->findLatest();
        return $this->render('admin/film/index.html.twig', [
            'controller_name' => 'AdminFilmController',
            'films' => $films
        ]);
    }

    /**
     * @Route("/admin/filmOldest", name="admin.film.oldest")
     */
    public function indexOldest()
    {
        $films = $this->FilmRepo->findOldest();
        return $this->render('admin/film/index.html.twig', [
            'controller_name' => 'AdminFilmController',
            'films' => $films
        ]);
    }

    /**
     * @Route("/admin/filmABOrder", name="admin.film.aBOrder")
     */
    public function indexABOrder()
    {
        $films = $this->FilmRepo->findByABorder();
        return $this->render('admin/film/index.html.twig', [
            'controller_name' => 'AdminFilmController',
            'films' => $films
        ]);
    }

    /**
     * @Route("/admin/filmZYOrder", name="admin.film.zYOrder")
     */
    public function indexZYOrder()
    {
        $films = $this->FilmRepo->findByZYOrder();
        return $this->render('admin/film/index.html.twig', [
            'controller_name' => 'AdminFilmController',
            'films' => $films
        ]);
    }

    /**
     *  @Route("/admin/film/ajouter", name="admin.film.new")
     */
    public function new(Request $request)
    {
        $film = new Film();
        $film->setUpdatedAt(new \DateTime('now', new \DateTimeZone('Europe/Paris')));
        $form = $this->createForm(FilmType::class, $film);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($film);
            $this->em->flush();
            $this->addFlash('success', 'Le film a bien été créé !');
        }

        $langue = new Langue();
        $formLangue = $this->createForm(LangueType::class, $langue);
        $langueList = $this->langueRepo->findAllDesc();

        return $this->render('admin/film/new.html.twig', [
            'film' => $film,
            'form' => $form->createView(),
            'formLangue' => $formLangue->createView(),
            'langueList' => $langueList,
        ]);
    }

    /**
     * @Route("/admin/film/{id}", name="admin.film.edit", methods="GET|POST")
     */
    public function edit(Film $film, Request $request, $id)
    {
        $film = $this->FilmRepo->find($id);
        $form = $this->createForm(FilmType::class, $film);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $film->setUpdatedAt(new \DateTime('now', new \DateTimeZone('Europe/Paris')));
            $this->em->flush();
            $this->addFlash('success', 'Le film a bien été modifié !');
        }

        $langue = new Langue();
        $formLangue = $this->createForm(LangueType::class, $langue);
        $langueList = $this->langueRepo->findAllDesc();

        return $this->render('admin/film/edit.html.twig', [
            'film' => $film,
            'form' => $form->createView(),
            'formLangue' => $formLangue->createView(),
            'langueList' => $langueList,
        ]);
    }

    /**
     * @Route("/admin/film/{id}", name="admin.film.delete", methods="DELETE")
     */
    public function delete(Film $film, Request $request)
    {
         $this->em->remove($film);
         $this->em->flush();  
        $this->addFlash('success', 'Le film a bien été supprimé !');
        return $this->redirectToRoute('admin.film.index');
    }

    /**
     * @Route("/admin/film/ajouter/ajax", name="admin.film.ajax")
     */
    public function ajax(EntityManagerInterface $em, Request $request)
    {
        $donnee = $request->request->get('donnee');
        $langue = new Langue();
        $langue->setNom($donnee);
        $em->persist($langue);
        $em->flush();

        $langueList = $this->langueRepo->findAllDesc();

        $langueTab = [];
        foreach ($langueList as $langue){
            $langueTab[$langue->getId()] = $langue->getNom();
        }  
             
        $response = new Response(json_encode($langueTab));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
