<?php
namespace App\Vue;

class Vue_Connexion
{

    static function donneHTML(string $msgErreur = ""): string
    {
        $str = "<h1>Bienvenue dans le bar !!</h1>
 $msgErreur
 <form method='post' action='/seconnecter'>
    <label for='mailUtilisateur'>Mail d'utilisateur :</label>
    <input type='email' id='mailUtilisateur' name='mailUtilisateur' required>
    <br>
    <label for='motDePasse'>Mot de passe :</label>
    <input type='password' id='motDePasse' name='motDePasse'
    required>
    <button type='submit'>Se connecter</button>
    </form>";
        return $str;

    }
}