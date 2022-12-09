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
        $user = $this->getUser();
        $form = $this->createForm(UserCommandeType::class, $user);
         
          $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {
           
           $userRepository->save($user, true);

           return $this->redirectToRoute('app_home');
       }

        return $this->renderForm('adresse_livraison/index.html.twig', [
            'user' => $user,
            
            'form' => $form,
        ]);
    }
}
