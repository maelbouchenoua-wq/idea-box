<?php
// US 14 : routeur pour le serveur intégré de PHP, qui ignore le .htaccess.
// Lancement : php -S localhost:8000 router.php
$chemin = rawurldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/');

if (preg_match('#(^|/)(\.git|\.idea|includes|sql)(/|$)|/(README\.md|\.gitignore|\.htaccess|router\.php)$#i', $chemin)) {
    http_response_code(404);
    exit('Page introuvable.');
}

// false : le serveur intégré sert normalement le fichier demandé.
return false;
