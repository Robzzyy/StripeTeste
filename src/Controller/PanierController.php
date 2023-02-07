<?php

namespace App\Controller;

use DateTime;
use App\Entity\Detail;
use App\Entity\Produit;
use App\Entity\Commande;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface as Session;

/**
 * @Route("/panier")
 */
class PanierController extends AbstractController
{
    /**
     * @Route("/", name="app_panier")
     */
    // Cette fonction publique s'appelle "index" et prend en paramètre un objet "Session"
public function index(Session $session): Response
{
    // On récupère la valeur de la clé "panier" dans la session, ou un tableau vide si la clé n'existe pas
    $panier = $session->get("panier", []);
    // Elle renvoie la vue "panier/index.html.twig" avec un tableau associatif de données
    return $this->render('panier/index.html.twig', [
        // La clé "panier" contiendra la valeur récupérée de la session
        'panier' => $panier,
    ]);
}



    /**
     * @Route("/ajouter-produit-{id}", name="app_panier_ajouter", requirements={"id"="\d+"})
     */
    // Cette fonction publique s'appelle "ajouter" et prend en paramètre l'identifiant du produit, un objet "ProduitRepository", un objet "Session", et un objet "Request"
public function ajouter($id, ProduitRepository $pr, Session $session, Request $rq)
{
    // On récupère la quantité dans la requête (query), sinon la quantité par défaut est 1
    $quantite = $rq->query->get("qte", 1) ?: 1;
    // On récupère le produit à partir de l'identifiant et de l'objet "ProduitRepository"
    $produit = $pr->find($id);
    // On récupère ce qui est déjà présent dans le panier en session
    $panier = $session->get("panier", []);
    
    // On définit une variable pour savoir si le produit est déjà dans le panier
    $produitDejaDansPanier = false;
    // Pour chaque ligne du panier
    foreach ($panier as $indice => $ligne) {
        // Si le produit actuel a le même identifiant que celui dans la ligne
        if ($produit->getId() == $ligne["produit"]->getId()) {
            // On augmente la quantité pour cette ligne
            $panier[$indice]["quantite"] += $quantite;
            // On marque que le produit est déjà dans le panier
            $produitDejaDansPanier = true;
            break;  // pour sortir de la boucle foreach
        }
    }
    // Si le produit n'est pas déjà dans le panier
    if (!$produitDejaDansPanier) {
        // On ajoute une nouvelle ligne au panier en indiquant la quantité et le produit
        $panier[] = ["quantite" => $quantite, "produit" => $produit];
    }

    // On remet le panier dans la session à l'indice 'panier'
    $session->set("panier", $panier);  

    // On compte le nombre total de produits dans le panier
    $nb = 0;
    foreach ($panier as $ligne){
        $nb += $ligne["quantite"];
    }

    // On renvoie le nombre total de produits dans le panier en format JSON
    return $this->json($nb);
}


    /** 
     * @Route("/vider", name="app_panier_vider")
     */

   //Fonction pour vider le panier
public function vider(Session $session)
{
    //Suppression de la variable 'panier' de la session
    $session->remove("panier");
    
    //Redirection vers la page du panier
    return $this->redirectToRoute("app_panier");
}



    /** 
     * @Route("/supprimer-produit-{id}", name="app_panier_supprimer", requirements={"id"="\d+"})
     */

    //Fonction pour supprimer un produit du panier
public function supprimer(Produit $produit, Session $session)
{
    //Récupération du panier en session
    $panier = $session->get("panier", []);
    
    //Parcours des produits dans le panier pour trouver celui à supprimer
    foreach ($panier as $indice => $ligne) {
        if ($ligne['produit']->getId() == $produit->getId()) {
            //Suppression du produit
            unset($panier[$indice]);
            break;
        }
    }
    
    //Mise à jour du panier dans la session
    $session->set("panier", $panier);
    
    //Redirection vers la page du panier
    return $this->redirectToRoute("app_panier");
}


    /** 
     * @Route("/valider", name="app_panier_valider")
     
     */
    /**
 * Cette fonction valide une commande en enregistrant les informations 
 * dans la base de données.
 * 
 * @param Session $session               La session actuelle
 * @param ProduitRepository $produitRepository Le repository des produits
 * @param EntityManagerInterface $em    L'entity manager pour gérer les requêtes en base de données
 * @return RedirectionResponse           Une redirection vers la page de livraison ou vers le panier si vide
 */
public function valider(Session $session, ProduitRepository $produitRepository, EntityManagerInterface $em)
{
    // Récupération du panier enregistré en session
    $panier = $session->get("panier", []);
    
    if ($panier) {
        // Création d'une nouvelle commande
        $cmd = new Commande;
        $cmd->setDateEnregistrement(new DateTime());
        $cmd->setEtat("en Attente");
        // Affectation de l'utilisateur connecté à la propriété 'client' de l'objet $cmd
        $cmd->setUser($this->getUser()); 
        $montant = 0;
        
        // Pour chaque ligne du panier
        foreach ($panier as $ligne) {
            // Récupération du produit en base de données
            $produit = $produitRepository->find($ligne["produit"]->getId());
            $montant += $produit->getPrix() * $ligne["quantité"];

            // Création d'un nouveau détail de commande
            $detail = new Detail;
            $detail->setPrix($produit->getPrix());
            $detail->setQuantite($ligne["quantite"]);
            $detail->setProduit($produit);
            $detail->setCommande($cmd);
            // Ajout du détail de commande en attente d'exécution
            $em->persist($detail); 

            // Mise à jour du stock du produit
            $produit->setStock($produit->getStock() - $ligne["quantité"]);
        }
        $cmd->setMontant($montant);
        // Ajout de la commande en attente d'exécution
        $em->persist($cmd);
        // Exécution de toutes les requêtes en attente
        $em->flush(); 
        // Suppression du panier en session
        $session->remove("panier");
        // Ajout d'un message de succès
        $this->addFlash("success", "Votre commande a été enregistrée");
        // Redirection vers la page de livraison
        return $this->redirectToRoute("app_adresse_livraison");
    }
    // Ajout d'un message d'erreur si le panier est vide
    $this->addFlash("danger", "Le panier est vide. Vous ne pouvez pas valider la commande.");
    // Redirection vers le panier

    }
}

