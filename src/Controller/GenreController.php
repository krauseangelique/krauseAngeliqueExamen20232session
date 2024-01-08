<?php

namespace App\Controller;

use App\Entity\Genre;
use App\Form\GenreType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GenreController extends AbstractController
{
    // Route par défaut : elle va lister TOUS les genres de livres proposés
    #[Route('/genre', name: 'app_genre')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // Récupération du Repository Genre
        $repository = $entityManager->getRepository(Genre::class);

        // Récupération des genres via findAll()
        $genres = $repository->findAll();

        // affichage dans le Twig
        return $this->render('genre/index.html.twig', [
            'genres' => $genres,
        ]);
    }

    #[Route('/genre/ajouter', name:'app_genre_ajouter')]
    public function ajouterGenre(Request $request, EntityManagerInterface $entityManager): Response 
    {
        // Création d'un genre
        $genre = new Genre();
    
        // Création du formulaire pour le genre : AJOUT d'un genre
        $formGenre = $this->createForm(GenreType::class, $genre);
        $formGenre->handleRequest($request);

        if($formGenre->isSubmitted() && $formGenre->isValid()) {
            $genre = $formGenre->getData();

            // pour la DB
            $entityManager->persist($genre);
            $entityManager->flush();

            // redirige vers la liste des genres
            return $this->redirectToRoute('app_genre');
        }

        return $this->render('genre/ajout.html.twig', [
            //tableau associatif
            'form'=> $formGenre,
        ]);

    }

    // Création d'une route pour MODIFIER le genre
    #[Route('/genre/modifier/{id}', name: 'app_modifierGenre')]
    public function modifier(Request $request, Genre $genre, EntityManagerInterface $entityManager): Response
    {
        //création du formulaire
        $formGenre = $this->createForm(GenreType::class, $genre);  
        
        // préparation de la requête
        $formGenre->handleRequest($request);

        if ($formGenre->isSubmitted() && $formGenre->isValid()) {
            // récupération des datas
            $genre = $formGenre->getData();

            // DB
            $entityManager->flush($genre);

            //redirige vers la liste des Genres
            return $this->redirectToRoute('app_genre');
        }
        return $this->render('genre/modifier.html.twig', [

            'form' => $formGenre
        ]);
    }

}
