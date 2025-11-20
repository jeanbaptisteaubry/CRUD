<?php
namespace App\Vue;
class Vue_CreationUtilisateur {

static function donneHTML( $msgErreur="", array $listeCategorieUtilisateur):string
{ 
 $str = "<h1>Création d'une utilisateur</h1>
    <p>" . $msgErreur . "</p>
   <form action='/utilisateur/creer' method='post'>
         
 <table>
 <tr>
 <td><label for='nom'>Nom :</label> </td>
  <td><input type='text' id='nom' name='nom'><br><br></td> </tr>
   <tr> <td><label for='mail'>Mail :</label></td>
  <td><input type='email' id='mail' name='mail'><br><br></td></tr>
   <tr><td><label for='motdepasse1'>Mot de passe :</label></td>
  <td><input type='password' id='motdepasse1' name='motdepasse1'><br><br></td></tr>
   <tr><td><label for='motdepasse2'>Mot de passe 2 :</label></td>
  <td><input type='password' id='motdepasse2' name='motdepasse2'><br><br></td></tr>
  
  </tr>
  <tr>
  <td><label for='categorieUtilisateur'>Catégorie utilisateur :</label></td>
  <td><select id='categorieUtilisateur' name='categorieUtilisateur'>";
  foreach ($listeCategorieUtilisateur as $categorieUtilisateur) {
      $str .= "<option value='" . $categorieUtilisateur->getId() . "'>" . $categorieUtilisateur->getLibelle() . "</option>";
  }
  $str .= "
  </select></td>
  </tr>
   <tr><td colspan=3><input type='submit' value='Créer'></td></tr>
 </table>

    </form>
     ";
    return $str;

}
}