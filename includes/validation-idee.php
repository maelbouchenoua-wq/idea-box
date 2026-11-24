<?php

// Le schéma utilise des vARCHAR pour le titre et le pseudo, et un TEXT pour la description
const LIMITES_IDEE = ['pseudo' => 50, 'title' => 100, 'description' => 65535];

// Renvoie le message à afficher près du champ, ou null si le texte est accepté
function erreurChampIdee(string $champ, string $texte): ?string
{
    if (preg_match('//u', $texte) !== 1) {
        return 'Ce champ contient un caractère illisible. Vérifie le texte saisi.';
    }
    // Un champ repli uniquement d’espaces compte aussi comme vide
    if ($texte === '' || preg_match('/\A\s+\z/u', $texte) === 1) {
        return 'Ce champ est obligatoire.';
    }

    $limite = LIMITES_IDEE[$champ];
    if ($champ === 'description') {
        // Un champ TEXT est limité en octets. Un caractère accentué peut en occuper plusieurs
        return strlen($texte) > $limite ? 'La description est trop longue (65 535 octets maximum).' : null;
    }

    // En mode UTF-8, le point compte un caractère entier
    if (preg_match('/\A.{1,' . $limite . '}\z/us', $texte) !== 1) {
        return "Ce champ est limité à $limite caractères.";
    }
    return null;
}
