<?php

namespace App\Controleur;

use App\Entity\Utilisateur;
use App\Entity\Boisson;
use App\Vue\Vue_BasDePage;
use App\Vue\Vue_CreationBoisson;
use App\Vue\Vue_CreationUtilisateur;
use App\Vue\Vue_EditerBoisson;
use App\Vue\Vue_Entete;
use App\Vue\Vue_ListeUtilisateur;
use AppendIterator;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Doctrine\ORM\EntityManager;

class Controleur_Utilisateur
{
    private EntityManager $entityManager;
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function Accueil(Request $request, Response $response, array $args): Response
    {
        $listeUtilisateur = $this->entityManager->getRepository(Utilisateur::class)->findAll();

        //Il a cliqué sur changer Mot de passe. Cas pas fini
        $strHtml = Vue_Entete::donneHTML() .
            Vue_ListeUtilisateur::donneHTML($listeUtilisateur) .
            Vue_BasDePage::donneHTML();
        $response->getBody()->write($strHtml);
        return $response;
    }

    public function Creation(Request $request, Response $response, array $args): Response
    {


        $strHtml = Vue_Entete::donneHTML() .
            Vue_CreationUtilisateur::donneHTML() .
            Vue_BasDePage::donneHTML();
        $response->getBody()->write($strHtml);
        return $response;
    }

    public function Creer(Request $request, Response $response, array $args): Response
    {
        //Récupération des données du formulaire
        $msgErreur = "";
        if (isset($_REQUEST['nom'], $_REQUEST['motdepasse1'], $_REQUEST['motdepasse2'])) {
            $nom = $_REQUEST['nom'] ?? '';
            $motdepasse1 = $_REQUEST['motdepasse1'] ?? '';
            $motdepasse2 = $_REQUEST['motdepasse2'] ?? '';
            if ($motdepasse1 === $motdepasse2) {
                if (calculComplexiteMdp($motdepasse1) > 70) {
                    //Vérification que le pseudo n'existe pas déjà
                    $existingUser = $this->entityManager->getRepository(Utilisateur::class)->findOneBy(['nomUtilisateur' => $nom]);

                    if (!$existingUser) {

                        //Création de l'utilisateur
                        $utilisateur = new Utilisateur($nom, password_hash($motdepasse1, PASSWORD_DEFAULT));

                        //Sauvegarde en base de données
                        $this->entityManager->persist($utilisateur);
                        $this->entityManager->flush();

                        $listeUtilisateur = $this->entityManager->getRepository(Utilisateur::class)->findAll();

                        //Il a cliqué sur changer Mot de passe. Cas pas fini
                        $strHtml = Vue_Entete::donneHTML() .
                            Vue_ListeUtilisateur::donneHTML($listeUtilisateur, "Utilisateur " . $nom . " créé.") .
                            Vue_BasDePage::donneHTML();
                        $response->getBody()->write($strHtml);
                        return $response;
                    } else {
                        $msgErreur = "Le nom d'utilisateur existe déjà. Veuillez en choisir un autre.";
                    }
                } else {
                    $msgErreur = "Le mot de passe est trop faible. Veuillez choisir un mot de passe plus complexe.";
                }
            } else {
                $msgErreur = "Les mots de passe ne correspondent pas.";
            }
        } else {
            $msgErreur = "Tous les champs doivent être remplis.";
        }


        $strHtml = Vue_Entete::donneHTML() .
            Vue_CreationUtilisateur::donneHTML($msgErreur) .
            Vue_BasDePage::donneHTML();
        $response->getBody()->write($strHtml);
        return $response;
    }


}