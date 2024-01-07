<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class LivreController extends AbstractController
{
    // Route et fonction d'exemple
    // #[Route('/livre', name: 'app_livre')]
    // public function index(): Response
    // {
    //     return $this->render('livre/index.html.twig', [
    //         'controller_name' => 'LivreController',
    //     ]);
    // }

    // Route HOME qui ICI va lister TOUS les livres
    #[Route('/', name: 'app_home_listeLivres')]
    // l'<EntityManagerInterface permet d'accéder au Repository (couche Modèle du MVC et ainsi accède aux requêtes et informations de la DB)
    public function home_liste(EntityManagerInterface $entityManager): Response
    {
        return $this->render('livre/index.html.twig', [
            'liste_home' => 'LivreController',
        ]);
    }
}
