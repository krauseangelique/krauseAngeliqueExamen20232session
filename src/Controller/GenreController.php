<?php

namespace App\Controller;

use App\Entity\Genre;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
