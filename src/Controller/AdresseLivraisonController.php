<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserCommandeType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdresseLivraisonController extends AbstractController
{
    #[Route('/adresse/livraison', name: 'app_adresse_livraison',methods: ['GET', 'POST'])]
    public function payement(Request $request, UserRepository $userRepository ): Response
    {  
        // Récupération de l'utilisateur connecté
$user = $this->getUser();

// Création d'un formulaire pour la commande d'un utilisateur
$form = $this->createForm(UserCommandeType::class, $user);

// Gestion de la requête envoyée à partir du formulaire
$form->handleRequest($request);

// Vérification de la soumission et de la validité du formulaire
if ($form->isSubmitted() && $form->isValid()) {

  // Enregistrement de l'utilisateur dans la base de données
  $userRepository->save($user, true);

  // Redirection vers la page d'accueil
  return $this->redirectToRoute('app_home');
}

// Affichage du formulaire d'adresse de livraison
return $this->renderForm('adresse_livraison/index.html.twig', [
  'user' => $user,
  'form' => $form,
]);

    }
}
