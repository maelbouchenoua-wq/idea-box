<?php
// US 14 : réglages de sécurité communs à toutes les pages.

// Le navigateur ne doit pas deviner le type d'un fichier, ni afficher la page dans un cadre (clickjacking).
// La CSP n'autorise que les fichiers du site : un script injecté depuis un autre domaine est bloqué.
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('Referrer-Policy: same-origin');
header("Content-Security-Policy: default-src 'self'; frame-ancestors 'none'; form-action 'self'; base-uri 'self'");
// Inutile d'annoncer la version de PHP aux visiteurs.
header_remove('X-Powered-By');

if (session_status() !== PHP_SESSION_ACTIVE) {
    // HttpOnly : le cookie de session n'est pas lisible en JavaScript.
    // SameSite=Lax : le cookie n'est pas envoyé quand un autre site poste un formulaire vers le nôtre.
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'httponly' => true,
        'samesite' => 'Lax',
        'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
    ]);
    session_start();
}

// Jeton anti-CSRF : un nombre aléatoire gardé en session et recopié dans chaque formulaire qui modifie la base.
if (empty($_SESSION['jeton_csrf'])) {
    $_SESSION['jeton_csrf'] = bin2hex(random_bytes(32));
}

function jetonCsrf(): string
{
    return $_SESSION['jeton_csrf'];
}

// hash_equals compare en temps constant ; un jeton absent ou qui n'est pas une chaîne est refusé.
function jetonCsrfValide(mixed $jeton): bool
{
    return is_string($jeton) && hash_equals($_SESSION['jeton_csrf'], $jeton);
}
