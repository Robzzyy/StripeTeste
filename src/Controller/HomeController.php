<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    // Cette fonction publique s'appelle "index" et prend en paramètre un objet "ProduitRepository"
public function index(ProduitRepository $produitRepository): Response
{
    // Elle renvoie la vue "home/index.html.twig" avec un tableau associatif de données
    return $this->render('home/index.html.twig', [
        // La clé "listeProduits" contiendra tous les produits trouvés en utilisant la méthode "findAll" de l'objet "ProduitRepository"
        'listeProduits' => $produitRepository->findAll()
    ]);
}

}
