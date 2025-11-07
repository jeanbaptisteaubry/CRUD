<?php
namespace App\Vue;
class Vue_ListeBoisson {

static function donneHTML(array $tableauBoisson, string $msgErreur=""):string
{ 
 $str = "<h1>Liste des boissons</h1>
 $msgErreur
 <table>
 <tr>
    <th>Nom</th>
    <th>Volume en cl</th>
    <th>Prix (€)</th>
    <th>Catégorie</th>
    <th></th>
</tr>";
    foreach($tableauBoisson as $boisson)
    {
        $str .= "<tr>
            <td><a href='/boisson/editer/".$boisson->getId()."'>".$boisson->getNom()."</a></td>
            <td>".$boisson->getVolumeCL()."</td>
            <td>".$boisson->getPrix()."</td>
            <td>".$boisson->getCategorie()->getLibelle()."</td>
        <td>
            <form action='/boisson/suppression/".$boisson->getId()."' method='post'>
                <input type='submit' value='Supprimer'>
            </form>
        </td></tr>";
    }

    $str .= "</table>
    Pour créer une nouvelle boisson, cliquez <a href='/boisson/creation'>ici</a>.<br>   
    ";
    return $str;

}
}