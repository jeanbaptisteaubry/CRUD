<?php

namespace App\Controleur;

use App\Entity\Categorie;
use App\Vue\Vue_BasDePage;
use App\Vue\Vue_EditerCategorie;
use App\Vue\Vue_Entete;
use App\Vue\Vue_ListeCategorie;
use App\Vue\Vue_CreationCategorie;
use AppendIterator;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Doctrine\ORM\EntityManager;

class Controleur_Categorie
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
            Vue_ListeCategorie::donneHTML($listeCategorie) .
            Vue_BasDePage::donneHTML();


        $response->getBody()->write($strHtml);
        return $response;
    }

    public function Creation(Request $request, Response $response, array $args): Response
    {
        //Il a cliqué sur changer Mot de passe. Cas pas fini
        $strHtml = Vue_Entete::donneHTML() .
            Vue_CreationCategorie::donneHTML() .
            Vue_BasDePage::donneHTML();


        $response->getBody()->write($strHtml);
        return $response;
    }

    public function Creer(Request $request, Response $response, array $args): Response
    {

        $nvCategorie = new Categorie($_REQUEST["libelle"]);
        $this->entityManager->persist($nvCategorie);
        $this->entityManager->flush();

        $listeCategorie = $this->entityManager->getRepository(Categorie::class)->findAll();

        $strHtml = Vue_Entete::donneHTML() .
            Vue_ListeCategorie::donneHTML($listeCategorie) .
            Vue_BasDePage::donneHTML();


        $response->getBody()->write($strHtml);
        return $response;
    }

    public function Suppression(Request $request, Response $response, array $args): Response
    {
        $idCategorie = $args['idCategorie'];
        $categorie = $this->entityManager->getRepository(Categorie::class)->findOneBy(['id' => $idCategorie] );

        $boissons = $this->entityManager->getRepository(\App\Entity\Boisson::class)->findBy(['categorie' => $categorie]);
        $msgErreur ="";
        if($boissons){
             $msgErreur = "Suppression impossible : des boissons sont associées à cette catégorie.";
        }
        else
        {
            $this->entityManager->remove($categorie);
        $this->entityManager->flush();    
        }

        

        $listeCategorie = $this->entityManager->getRepository(Categorie::class)->findAll();

        //Il a cliqué sur changer Mot de passe. Cas pas fini
        $strHtml = Vue_Entete::donneHTML() .
            Vue_ListeCategorie::donneHTML($listeCategorie, $msgErreur) .
            Vue_BasDePage::donneHTML();


        $response->getBody()->write($strHtml);
        return $response;
    }

    public function Editer(Request $request, Response $response, array $args): Response
    {
        $idCategorie = $args['idCategorie'];
        $categorie = $this->entityManager->getRepository(Categorie::class)->findOneBy(['id' => $idCategorie] );

       
        $strHtml = Vue_Entete::donneHTML() .
            Vue_EditerCategorie::donneHTML($categorie) .
            Vue_BasDePage::donneHTML();


        $response->getBody()->write($strHtml);
        return $response;
    }

    public function Modifier(Request $request, Response $response, array $args): Response
    {
        $idCategorie = $args['idCategorie'];
        $categorie = $this->entityManager->getRepository(Categorie::class)->findOneBy(['id' => $idCategorie] );
        $categorie->setLibelle($_REQUEST["libelle"]);
        $this->entityManager->persist($categorie);
        $this->entityManager->flush();
       
        $strHtml = Vue_Entete::donneHTML() .
            Vue_EditerCategorie::donneHTML($categorie) .
            Vue_BasDePage::donneHTML();


        $response->getBody()->write($strHtml);
        return $response;
    }

    

}