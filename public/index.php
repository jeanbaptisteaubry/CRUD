<?php
//error_log("page debut");
session_start();
include_once "../vendor/autoload.php";
include_once "../bootstrap.php";
use Slim\Factory\AppFactory; 
use Slim\Http\Request;

$app = AppFactory::create();
//$boissonControleur = new \App\Controleur\Controleur_Boisson();
$categorieControleur = new \App\Controleur\Controleur_Categorie($entityManager);

/*
$app->get('/boisson', [$boissonControleur, 'Accueil']);
$app->get('/boisson/creation', [$boissonControleur, 'Creation']);
$app->get('/boisson/suppression/{idBoisson}', [$boissonControleur, 'Suppression']);
$app->get('/boisson/editer/{idBoisson}', [$boissonControleur, 'Editer']);
$app->get('/boisson/modifier/{idBoisson}', [$boissonControleur, 'Modifier']);
*/
$app->get('/categorie', [$categorieControleur, 'Accueil']);
$app->get('/categorie/creation', [$categorieControleur, 'Creation']);
$app->post('/categorie/creer', [$categorieControleur, 'Creer']);
$app->post('/categorie/suppression/{idCategorie}', [$categorieControleur, 'Suppression']);
$app->get('/categorie/editer/{idCategorie}', [$categorieControleur, 'Editer']);
$app->post('/categorie/modifier/{idCategorie}', [$categorieControleur, 'Modifier']);


$app->run();