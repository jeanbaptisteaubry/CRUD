<?php
namespace App\Vue;
use App\Entity\Utilisateur;
class Vue_Menu
{

    static function donneHTML(?Utilisateur $utilisateur = null): string
    {
        //Menu de navigation, horizontal, avec connexion à droite si utilisateur non null
        $str = "<nav>
        <ul style='list-style-type: none; display: flex; justify-content: space-between; align-items: center; margin: 10; padding: 10;'>";
        if ($utilisateur == null) {
            $str .= "
            <li>
                <a href='/'>Accueil</a>
            </li>
            <li style='margin-left: auto;'>
                <a href='/sinscrire'>S'inscrire</a>
            </li>
            <li style='margin-left: auto;'>
                <a href='/connexion'>Connexion</a>
            </li>";

        } else {
            if ($utilisateur->getCategorieUtilisateur()->getLibelle() === 'root') {

                $str .= "
            <li>
                <a href='/'>Accueil</a>
            </li>
            <li>
                <a href='/boisson'>Boissons</a>
            </li>
            <li>
                <a href='/categorie'>Catégories</a>
            </li>
            <li>
                <a href='/utilisateur'>Utilisateurs</a>
            </li>
            <li style='margin-left: auto;'>
                        " . $utilisateur->getNomUtilisateur() . "
                 <a href='/deconnexion'>Déconnexion</a> 
            </li>";
            }


        }
        $str .= "</ul>";
        return $str;
    }
}