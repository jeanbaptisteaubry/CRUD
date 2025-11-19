<?php
namespace App\Vue;
class Vue_CreationUtilisateur {

static function donneHTML( $msgErreur=""):string
{ 
 $str = "<h1>Création d'une utilisateur</h1>
    <p>" . $msgErreur . "</p>
   <form action='/utilisateur/creer' method='post'>
         
 <table>
 <label for='nom'>Nom :</label>
 <input type='text' id='nom' name='nom'><br><br>
 <label for='motdepasse1'>Mot de passe :</label>
 <input type='password' id='motdepasse1' name='motdepasse1'><br><br>
 <label for='motdepasse2'>Mot de passe 2 :</label>
 <input type='password' id='motdepasse2' name='motdepasse2'><br><br>
  
   
 </table>
<input type='submit' value='Créer'>
    </form>
     ";
    return $str;

}
}