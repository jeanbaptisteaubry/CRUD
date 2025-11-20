<?php
namespace App\Vue;

class Vue_Accueil
{

    static function donneHTML(array $tableauCategorie, string $msgErreur = ""): string
    {
        $str = "<h1>Bienvenue dans le bar !!</h1>
 $msgErreur
 ";
        foreach ($tableauCategorie as $categorie) {
            $str .= "<ul>
            <label>" . $categorie->getLibelle() . "</label>";
            foreach ($categorie->getBoissons() as $boisson) {
                $str .= "<li>
                        <label>" . $boisson->getNom() . "</label>";

                $str .= "</li>";
            }
            $str .= "</ul>";
        }

        $str .= "   ";
        return $str;

    }
}