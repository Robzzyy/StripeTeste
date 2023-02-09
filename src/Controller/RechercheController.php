<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RechercheController extends AbstractController
{
    /**
     * @Route("/recherche", name="app_recherche")
     */
    
/* Ce code représente une fonction "index" qui prend en entrée une requête HTTP (Request $rq) et un référentiel de produits (ProduitRepository $pr). La fonction retourne une réponse HTTP (Response). */
    public function index(Request $rq, ProduitRepository $pr): Response
    {
       // Récupération du mot de recherche depuis la requête HTTP
$mot = $rq->query->get("search");

// Recherche des produits correspondants à ce mot de recherche
$produitsTrouves = $pr->recherche($mot);

// Affichage des résultats de la recherche
return $this->render('recherche/index.html.twig', [
  'produits'  => $produitsTrouves,
  'mot'       => $mot
]);

    }

    /**
     * @Route("/recherche-ajax", name="app_recherche_ajax")
     */
    

    public function ajax(Request $rq, ProduitRepository $pr): Response
    {
        $mot = $rq->query->get("search");
        $produitsTrouves = $pr->recherche($mot);
        return $this->render('recherche/ajax.html.twig', [
            'produits'  => $produitsTrouves,
            'mot'       => $mot
        ]);
    }
}

