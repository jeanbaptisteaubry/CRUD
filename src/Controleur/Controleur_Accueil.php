<?php

namespace App\Controleur;

use App\Entity\Categorie;
use App\Entity\Boisson;
use App\Vue\Vue_BasDePage;
use App\Vue\Vue_Connexion;
use App\Vue\Vue_EditerBoisson;
use App\Vue\Vue_Entete;
use App\Vue\Vue_ListeCategorie;
use App\Vue\Vue_CreationCategorie;
use App\Vue\Vue_ListeBoisson;
use App\Vue\Vue_Accueil;
use App\Vue\Vue_Menu;
use AppendIterator;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Doctrine\ORM\EntityManager;

class Controleur_Accueil
{
    private EntityManager $entityManager;
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function Accueil(Request $request, Response $response, array $args): Response
    {
        $listeCategorie = $this->entityManager->getRepository(Categorie::class)->findAll();

        //Il a cliqué sur changer Mot de passe. Cas pas fini
        $strHtml = Vue_Entete::donneHTML() .
            Vue_Menu::donneHTML() .
            Vue_Accueil::donneHTML($listeCategorie) .
            Vue_BasDePage::donneHTML();


        $response->getBody()->write($strHtml);
        return $response;
    }
    public function Connexion(Request $request, Response $response, array $args): Response
    {
        //  $listeCategorie = $this->entityManager->getRepository(Categorie::class)->findAll();

        //Il a cliqué sur changer Mot de passe. Cas pas fini
        $strHtml = Vue_Entete::donneHTML() .
            Vue_Menu::donneHTML() .
            Vue_Connexion::donneHTML() .
            Vue_BasDePage::donneHTML();

        $response->getBody()->write($strHtml);
        return $response;
    }

    public function Seconnecter(Request $request, Response $response, array $args): Response
    {
        //Ici on doit avoir un pseudo et un mdp !
        if (isset($_REQUEST['mailUtilisateur']) == false || isset($_REQUEST['motDePasse']) == false) {
            $strHtml = Vue_Entete::donneHTML() .
                Vue_Menu::donneHTML() .
                Vue_Connexion::donneHTML("Informations manquantes") .
                Vue_BasDePage::donneHTML();

            $response->getBody()->write($strHtml);
            return $response;
        }
        $mailUtilisateur = $_REQUEST['mailUtilisateur'];
        $motDePasse = $_REQUEST['motDePasse'];

        //On va chercher l'utilisateur en base de données
        $utilisateur = $this->entityManager->getRepository(\App\Entity\Utilisateur::class)
            ->findOneBy(['mailUtilisateur' => $mailUtilisateur]);
        //  $listeCategorie = $this->entityManager->getRepository(Categorie::class)->findAll();
        $pbm = false;
        if ($utilisateur == null) {
            $pbm = true;
        }
        if (!password_verify($motDePasse, $utilisateur->getMotDePasseHash()) == false) {
            $pbm = true;
        }
        if (!$pbm) {
            //Connexion OK
            //On crée la session

            $_SESSION['utilisateurId'] = $utilisateur->getId();
            $_SESSION['categorieUtilisateur'] = $utilisateur->getCategorieUtilisateur()->getLibelle();

            $listeCategorie = $this->entityManager->getRepository(Categorie::class)->findAll();

            $strHtml = Vue_Entete::donneHTML() .
                Vue_Menu::donneHTML($utilisateur) .
                Vue_Accueil::donneHTML($listeCategorie) .
                Vue_BasDePage::donneHTML();
            $response->getBody()->write($strHtml);
            return $response;
        }
        //Il a cliqué sur changer Mot de passe. Cas pas fini


        $strHtml = Vue_Entete::donneHTML() .
            Vue_Menu::donneHTML() .
            Vue_Connexion::donneHTML("Erreur de connexion") .
            Vue_BasDePage::donneHTML();

        $response->getBody()->write($strHtml);
        return $response;
    }

     public function Deconnexion(Request $request, Response $response, array $args): Response
    {
        
        unset($_SESSION['utilisateurId']);
        unset($_SESSION['categorieUtilisateur']);
        //Il a cliqué sur changer Mot de passe. Cas pas fini
        session_destroy();

        $strHtml = Vue_Entete::donneHTML() .
            Vue_Menu::donneHTML() .
            Vue_Connexion::donneHTML("Déconnexion réussie !!") .
            Vue_BasDePage::donneHTML();

        $response->getBody()->write($strHtml);
        return $response;
    }

    
     public function Sinscrire(Request $request, Response $response, array $args): Response
    {
        
    }
    
}

