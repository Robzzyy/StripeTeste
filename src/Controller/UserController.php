<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/user')]
class UserController extends AbstractController
{
    
  /*  Ce code représente une méthode "new" pour la création d'un nouvel utilisateur. */

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        // Création d'un nouvel objet utilisateur
        $user = new User();
    
        // Création du formulaire pour la saisie des informations de l'utilisateur
        $form = $this->createForm(UserType::class, $user);
    
        // Traitement de la requête soumise par l'utilisateur via le formulaire
        $form->handleRequest($request);
    
        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Hashage du mot de passe de l'utilisateur
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
    
            // Enregistrement des informations de l'utilisateur en base de données
            $userRepository->save($user, true);
    
            // Redirection vers la page de connexion
            return $this->redirectToRoute('app_login');
        }
    
        // Affichage du formulaire pour la saisie des informations de l'utilisateur
        return $this->renderForm('/user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
    

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        // Affichage des informations de l'utilisateur
        return $this->render('/user/show.html.twig', [
            'user' => $user,
  ]);
  
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {
       // Création d'un formulaire pour éditer les informations de l'utilisateur
    $form = $this->createForm(UserType::class, $user);

    // Gestion de la soumission du formulaire
    $form->handleRequest($request);

    // Si le formulaire est soumis et est valide
    if ($form->isSubmitted() && $form->isValid()) {
    // Sauvegarde des modifications de l'utilisateur
    $userRepository->save($user, true);

    // Redirection vers la page d'accueil avec un status HTTP "See Other" (303)
    return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
}

    // Affichage du formulaire pour éditer les informations de l'utilisateur
    return $this->renderForm('/user/edit.html.twig', [
    'user' => $user,
    'form' => $form,
]);

    }

    
}
