<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Form\LivreType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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


    // Route HOME qui va lister TOUS les livres (la page d'accueil listera les Livres)

    #[Route('/', name: 'app_home_listeLivres')]
    public function home_liste(EntityManagerInterface $entityManager): Response
    {
        //Récupération de mon Repository Livre
        $repository = $entityManager->getRepository(Livre::class);

        // Récupération de tous mes livres via findAll()
        $livres = $repository->findAll();

        // affichage dans le Twig
        return $this->render('livre/index.html.twig', [
            // 'controller_name' => 'LivreController',
            'livres' => $livres,
        ]);
    }

    // Création de Détail Livre
    #[Route('/livre/detail/{id}', name: 'app_detailLivre')]
    public function detail(Livre $livre): Response
    {
        //dd($livre);
        // je prends l'id
        return $this->render('livre/detail.html.twig', [
            'livre' => $livre,
        ]);
    }



    // Ajouter un LIVRE 
    // l'EntityManagerInterface permet d'accéder au Repository (couche Modèle du MVC et ainsi accèder aux requêtes et informations de la DB)
    #[Route('/livre/ajouter', name: 'app_livre_ajouter')]
    public function ajouter(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Création d'un livre
        $livre = new Livre();
        // set de la date d'ajout à la date de création
        $livre->setDateAjout(new DateTime());

        // Création du formulaire
        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData();
            // but, the original `$task` variable has also been updated
            $livre = $form->getData();

            // pour envoyer dans la DB
            $entityManager->persist($livre);

            $entityManager->flush();

            // redirige vers la liste de Livres
            return $this->redirectToRoute('app_home_listeLivres');
        }
        return $this->render('livre/ajout.html.twig');
    }
}
