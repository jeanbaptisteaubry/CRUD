<?php
namespace App\Vue;
class Vue_ListeCategorie {

static function donneHTML(array $tableauCategorie, string $msgErreur=""):string
{ 
 $str = "<h1>Liste des catégories</h1>
 $msgErreur
 <table>
 <tr><th>Libellé</th><th>Supprimer</th></tr>";
    foreach($tableauCategorie as $categorie)
    {
        $str .= "<tr><td><a href='/categorie/editer/".$categorie->getId()."'>".$categorie->getLibelle()."</td>
        <td>
            <form action='/categorie/suppression/".$categorie->getId()."' method='post'>
                <input type='submit' value='Supprimer'>
            </form>
        </td></tr>";
    }

    $str .= "</table>
    Pour créer une nouvelle catégorie, cliquez <a href='/categorie/creation'>ici</a>.<br>   
    ";
    return $str;

}
}