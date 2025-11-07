<?php

namespace App\Controleur;

use App\Entity\Categorie;
use App\Entity\Boisson;
use App\Vue\Vue_BasDePage;
use App\Vue\Vue_CreationBoisson;
use App\Vue\Vue_EditerBoisson;
use App\Vue\Vue_Entete;
use App\Vue\Vue_ListeCategorie;
use App\Vue\Vue_CreationCategorie;
use App\Vue\Vue_ListeBoisson;
use AppendIterator;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Doctrine\ORM\EntityManager;

class Controleur_Boisson
{
    private EntityManager $entityManager;
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function Accueil(Request $request, Response $response, array $args): Response
    {
        $listeBoisson = $this->entityManager->getRepository(Boisson::class)->findAll();

        //Il a cliqué sur changer Mot de passe. Cas pas fini
        $strHtml = Vue_Entete::donneHTML() .
            Vue_ListeBoisson::donneHTML($listeBoisson) .
            Vue_BasDePage::donneHTML();


        $response->getBody()->write($strHtml);
        return $response;
    }

    public function Creation(Request $request, Response $response, array $args): Response
    {
        $listeCategorie = $this->entityManager->getRepository(Categorie::class)->findAll();
        //Il a cliqué sur changer Mot de passe. Cas pas fini
        $strHtml = Vue_Entete::donneHTML() .
            Vue_CreationBoisson::donneHTML($listeCategorie) .
            Vue_BasDePage::donneHTML();




        $response->getBody()->write($strHtml);
        return $response;
    }

    public function Creer(Request $request, Response $response, array $args): Response
    {
        //Pour récupérer la catégorie associée à la boisson
        $categorie = $this->entityManager->getRepository(Categorie::class)->findOneBy(['id' => $_REQUEST["categorie"]]);

        $nvCategorie = new Boisson($_REQUEST["nom"], $_REQUEST["volumeCL"], $_REQUEST["prix"], $categorie);
        $this->entityManager->persist($nvCategorie);
        $this->entityManager->flush();

        $listeBoisson = $this->entityManager->getRepository(Boisson::class)->findAll();

        //Il a cliqué sur changer Mot de passe. Cas pas fini
        $strHtml = Vue_Entete::donneHTML() .
            Vue_ListeBoisson::donneHTML($listeBoisson) .
            Vue_BasDePage::donneHTML();

        $response->getBody()->write($strHtml);
        return $response;
    }

    public function Suppression(Request $request, Response $response, array $args): Response
    {
        $idBoisson = $args['idBoisson'];
        $boisson = $this->entityManager->getRepository(Boisson::class)->findOneBy(['id' => $idBoisson]);


        $this->entityManager->remove($boisson);
        $this->entityManager->flush();




        $listeBoisson = $this->entityManager->getRepository(Boisson::class)->findAll();

        //Il a cliqué sur changer Mot de passe. Cas pas fini
        $strHtml = Vue_Entete::donneHTML() .
            Vue_ListeBoisson::donneHTML($listeBoisson) .
            Vue_BasDePage::donneHTML();

        $response->getBody()->write($strHtml);
        return $response;
    }

    public function Editer(Request $request, Response $response, array $args): Response
    {
        $idBoisson = $args['idBoisson'];
        $boisson = $this->entityManager->getRepository(Boisson::class)->findOneBy(['id' => $idBoisson]);
        $listeCategorie = $this->entityManager->getRepository(Categorie::class)->findAll();

        $strHtml = Vue_Entete::donneHTML() .
            Vue_EditerBoisson::donneHTML($boisson, $listeCategorie) .
            Vue_BasDePage::donneHTML();


        $response->getBody()->write($strHtml);
        return $response;
    }

    public function Modifier(Request $request, Response $response, array $args): Response
    {
        $idBoisson = $args['idBoisson'];
        $boisson = $this->entityManager->getRepository(Boisson::class)->findOneBy(['id' => $idBoisson]);

        $boisson->setNom($_REQUEST["nom"]);

        $boisson->setPrix($_REQUEST["prix"]);

        $boisson->setVolumeCL($_REQUEST["volumeCL"]);


        $categorie = $this->entityManager->getRepository(Categorie::class)->findOneBy(['id' => $_REQUEST["categorie"]]);

        $boisson->setCategorie($categorie);

        $this->entityManager->persist($boisson);
        $this->entityManager->flush();

        $strHtml = Vue_Entete::donneHTML() .
            Vue_EditerBoisson::donneHTML($boisson,$this->entityManager->getRepository(Categorie::class)->findAll() ) .
            Vue_BasDePage::donneHTML();


        $response->getBody()->write($strHtml);
        return $response;
    }



}