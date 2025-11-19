<?php

namespace App\Vue;
class Vue_ListeUtilisateur
{

    static function donneHTML(array $tableauUtilisateur, $msg=""): string
    {
        $str = "<h1>Liste des utilisateurs</h1>
        <p>" . $msg . "</p>
    <table>
    <tr>
        <th>Nom d'utilisateur</th> 
        <th>Catégorie utilisateur</th> 
    </tr>";
        foreach ($tableauUtilisateur as $utilisateur) {
            $str .= "<tr>
            <td>" . $utilisateur->getNomUtilisateur() . "</td>
            <td>" . $utilisateur->getCategorieUtilisateur()->getLibelle() . "</td>
        </tr>";
        }
        $str .= "</table>
        Création d'un nouvel utilisateur : <a href='/utilisateur/creation'>ici</a>.<br>
    ";
        return $str;
    }

}