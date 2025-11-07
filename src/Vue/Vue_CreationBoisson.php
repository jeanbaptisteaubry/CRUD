<?php
namespace App\Vue;
class Vue_CreationBoisson {

static function donneHTML(array $listeCategorie):string
{ 
 $str = "<h1>Création d'une boisson</h1>
   <form action='/boisson/creer' method='post'>
         
 <table>
 <label for='nom'>Nom :</label>
 <input type='text' id='nom' name='nom'><br><br>
 <label for='volumeCL'>Volume (en cl) :</label>
 <input type='number' id='volumeCL' name='volumeCL'><br><br>
 <label for='prix'>Prix (€) :</label>
 <input type='text' id='prix' name='prix'><br><br>
 <label for='categorie'>Catégorie :</label>
 <select id='categorie' name='categorie'>";
  
    foreach($listeCategorie as $categorie)
    {
        $str.=" <option value='".$categorie->getId()."'>".$categorie->getLibelle()."</option>";
    } 

  $str.="</select><br><br>
   
 </table>
<input type='submit' value='Créer'>
    </form>
     ";
    return $str;

}
}