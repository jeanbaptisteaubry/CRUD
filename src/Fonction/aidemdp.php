<?php

function calculComplexiteMdp(string $mdp): int
{
    $univers = 0;

    if (preg_match('/[a-z]/', $mdp)) {
        $univers += 26; // Minuscules
    }
    if (preg_match('/[A-Z]/', $mdp)) {
        $univers += 26; // Majuscules
    }
    if (preg_match('/[0-9]/', $mdp)) {
        $univers += 10; // Chiffres
    }
    if (preg_match('/[\W_]/', $mdp)) {
        $univers += 10; // Caractères spéciaux
    }
   
    $complexite = log(pow($univers,strlen($mdp)))/log(2); // Longueur minimale
   

    return $complexite;
}