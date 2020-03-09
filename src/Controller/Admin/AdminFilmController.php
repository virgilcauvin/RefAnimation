<?php

namespace App\Controller\Admin;

use App\Entity\Film;
use App\Form\FilmType;
use App\Repository\FilmRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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


    public function __construct(FilmRepository $FilmRepo, EntityManagerInterface $em)
    {
        $this->FilmRepo = $FilmRepo;
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
            return $this->redirectToRoute('admin.film.index');
        }
        return $this->render('admin/film/new.html.twig', [
            'film' => $film,
            'form' => $form->createView()
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
            return $this->redirectToRoute('admin.film.index');
        }
        return $this->render('admin/film/edit.html.twig', [
            'film' => $film,
            'form' => $form->createView()
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
}
