<?php

namespace App\Controller;

use App\Entity\Produit;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProduitController extends AbstractController
{
    # [Route('/produit', name: 'app_produit')]


    /**
 * @Route("/fiche-produit-{id}", name="app_produit_show")
 */
 
/* Ce code représente une fonction "showFiche" qui prend en entrée un objet produit (Produit $produit). La fonction retourne une réponse HTTP (Response) */

public function showFiche(Produit $produit): Response
{
    // Récupération des détails du produit
$details = $produit->getDetails();

// Initialisation d'un compteur
$nb = 0;

// Boucle sur les détails du produit pour additionner les quantités
foreach($details as $d){
  $nb += $d->getQuantite();
}

// Affichage de la fiche produit
return $this->render('produit/fiche_produit.html.twig', [
  'produit' => $produit,
  "nb" => $nb
]);

}
}
