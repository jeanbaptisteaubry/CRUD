<?php

namespace App\Controleur;

use App\Entity\CategorieUtilisateur;
use App\Entity\Utilisateur;
use App\Entity\Boisson;
use App\Vue\Vue_BasDePage;
use App\Vue\Vue_CreationBoisson;
use App\Vue\Vue_CreationUtilisateur;
use App\Vue\Vue_EditerBoisson;
use App\Vue\Vue_Entete;
use App\Vue\Vue_ListeUtilisateur;
use App\Vue\Vue_ChangerMDPUtilisateur;
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
        $listeCategorieUtilisateur = $this->entityManager->getRepository(CategorieUtilisateur::class)->findAll();

        $strHtml = Vue_Entete::donneHTML() .
            Vue_CreationUtilisateur::donneHTML("", $listeCategorieUtilisateur) .
            Vue_BasDePage::donneHTML();
        $response->getBody()->write($strHtml);
        return $response;
    }

    public function Creer(Request $request, Response $response, array $args): Response
    {
        //Récupération des données du formulaire
        $msgErreur = "";
        if (isset($_REQUEST['nom'], $_REQUEST['motdepasse1'], $_REQUEST['motdepasse2'], $_REQUEST['mail']) && !empty($_REQUEST['nom']) && !empty($_REQUEST['motdepasse1']) && !empty($_REQUEST['motdepasse2']) && !empty($_REQUEST['mail'])) {
            $nom = $_REQUEST['nom'] ?? '';
            $mail = $_REQUEST['mail'] ?? '';
            $motdepasse1 = $_REQUEST['motdepasse1'] ?? '';
            $motdepasse2 = $_REQUEST['motdepasse2'] ?? '';
            if ($motdepasse1 === $motdepasse2) {
                if (calculComplexiteMdp($motdepasse1) > 70) {
                    //Vérification que le pseudo n'existe pas déjà
                    $existingUser = $this->entityManager->getRepository(Utilisateur::class)->findOneBy(['nomUtilisateur' => $nom]);

                    if (!$existingUser) {
                        $categorieUtilisateur = $this->entityManager->getRepository(CategorieUtilisateur::class)->findOneBy(['id' => $_REQUEST['categorieUtilisateur']]);

                        //Création de l'utilisateur
                        $utilisateur = new Utilisateur($nom, $mail, password_hash($motdepasse1, PASSWORD_DEFAULT, ), $categorieUtilisateur);

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

    function Supprimer(Request $request, Response $response, array $args): Response
    {
        $idUtilisateur = $args['idUtilisateur'];

        $utilisateur = $this->entityManager->getRepository(Utilisateur::class)->find($idUtilisateur);

        if ($utilisateur) {
            $this->entityManager->remove($utilisateur);
            $this->entityManager->flush();
        }

        $listeUtilisateur = $this->entityManager->getRepository(Utilisateur::class)->findAll();

        $strHtml = Vue_Entete::donneHTML() .
            Vue_ListeUtilisateur::donneHTML($listeUtilisateur, "Utilisateur supprimé.") .
            Vue_BasDePage::donneHTML();
        $response->getBody()->write($strHtml);
        return $response;
    }

    public function changerMDP(Request $request, Response $response, array $args): Response
    {
        $idUtilisateur = $args['idUtilisateur'];

        $strHtml = Vue_Entete::donneHTML() .
            Vue_ChangerMDPUtilisateur::donneHTML($idUtilisateur) .
            Vue_BasDePage::donneHTML();
        $response->getBody()->write($strHtml);
        return $response;
    }

    public function validerchangermdp(Request $request, Response $response, array $args): Response
    {
        $idUtilisateur = $args['idUtilisateur'];
        $msgErreur = "";
        if (
            isset($_REQUEST["ancienmdp"], $_REQUEST['motdepasse1'], $_REQUEST['motdepasse2'])
            && !empty($_REQUEST['ancienmdp'])
            && !empty($_REQUEST['motdepasse1'])
            && !empty($_REQUEST['motdepasse2'])
        ) {
            $existingUser = $this->entityManager->getRepository(Utilisateur::class)->findOneBy(['id' => $idUtilisateur]);

            $ancienmdp = $_REQUEST['ancienmdp'] ?? '';
            $motdepasse1 = $_REQUEST['motdepasse1'] ?? '';
            $motdepasse2 = $_REQUEST['motdepasse2'] ?? '';
            if ($motdepasse1 === $motdepasse2) {
                if (calculComplexiteMdp($motdepasse1) > 70) {
                    //Vérification que le pseudo n'existe pas déjà

                    if ($existingUser) {
                        if (password_verify($ancienmdp, $existingUser->getMotDePasseHash())) {

                            //Modification du mot de passe
                            $existingUser->setMotDePasseHash(password_hash($motdepasse1, PASSWORD_DEFAULT, ));

                            //Sauvegarde en base de données
                            $this->entityManager->persist($existingUser);
                            $this->entityManager->flush();

                            $listeUtilisateur = $this->entityManager->getRepository(Utilisateur::class)->findAll();

                            //Il a cliqué sur changer Mot de passe. Cas pas fini
                            $strHtml = Vue_Entete::donneHTML() .
                                Vue_ListeUtilisateur::donneHTML($listeUtilisateur, "Mot de passe changé") .
                                Vue_BasDePage::donneHTML();
                            $response->getBody()->write($strHtml);
                            return $response;
                        } else {
                            $msgErreur = "L'ancien mot de passe est incorrect.";
                        }
                    } else {
                        $msgErreur = "L'utilisateur n'existe plus !";
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
            Vue_ChangerMDPUtilisateur::donneHTML($idUtilisateur, $msgErreur) .
            Vue_BasDePage::donneHTML();
        $response->getBody()->write($strHtml);
        return $response;
    }

}

