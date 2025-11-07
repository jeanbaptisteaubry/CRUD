<?php
namespace App\Vue;

use App\Entity\Boisson;
class Vue_EditerBoisson
{

    static function donneHTML(Boisson $boisson, array $listeCategorie): string
    {
        $str = "<h1>Edition d'une boisson</h1>
   <form action='/boisson/modifier/".$boisson->getId()."' method='post'>
         
 <table>
 <label for='nom'>Nom :</label>
 <input type='text' id='nom' name='nom' value='".$boisson->getNom()."'><br><br>
 <label for='volumeCL'>Volume (en cl) :</label>
 <input type='number' id='volumeCL' name='volumeCL' value='".$boisson->getVolumeCL()."'><br><br>
 <label for='prix'>Prix (€) :</label>
 <input type='text' id='prix' name='prix' value='".$boisson->getPrix()."'><br><br>
 <label for='categorie'>Catégorie :</label>
 <select id='categorie' name='categorie'>";

        foreach ($listeCategorie as $categorie) {
            if ($categorie->getId() == $boisson->getCategorie()->getId()) {
                $str .= " <option value='" . $categorie->getId() . "' selected>" . $categorie->getLibelle() . "</option>";
            } else {
                $str .= " <option value='" . $categorie->getId() . "'>" . $categorie->getLibelle() . "</option>";
            }
        }

        $str .= "</select><br><br>
   
 </table>
<input type='submit' value='Modifier'>
    </form>
     ";
        return $str;

    }
}