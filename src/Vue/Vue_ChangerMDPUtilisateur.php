<?php
namespace App\Vue;
class Vue_ChangerMDPUtilisateur {

static function donneHTML( $idUtilisateur, $msgErreur=""):string
{ 
 $str = "<h1>Changer le mot de passe</h1>
    <p>" . $msgErreur . "</p>
   <form action='/utilisateur/validerchangermdp/".$idUtilisateur."' method='post'>
         
 <table>
   <label for='ancienmdp'>Ancien MDP :</label>
 <input type='password' id='ancienmdp' name='ancienmdp'><br><br>
 <label for='motdepasse1'>Mot de passe :</label>
 <input type='password' id='motdepasse1' name='motdepasse1'><br><br>
 <label for='motdepasse2'>Mot de passe 2 :</label>
 <input type='password' id='motdepasse2' name='motdepasse2'><br><br>
  
   
 </table>
<input type='submit' value='Valider'>
    </form>
     ";
    return $str;

}
}