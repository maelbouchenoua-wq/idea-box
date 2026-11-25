# idea-box

## Voir ses changements de style en local

Modifiez `assets/css/styles.css` dans la copie du projet ouverte par votre serveur PHP, enregistrez, puis actualisez la page. Le lien vers la feuille de style change automatiquement quand son contenu change.

Si la page affiche « La liste des idées est momentanément indisponible », vérifiez que MySQL est démarré. Après un premier téléchargement, ou si le dernier pull a retiré votre ancienne configuration, copiez `includes/config.example.php` vers `includes/config.php` et renseignez vos propres accès MySQL dans la copie. Gardez toute configuration locale déjà présente. Pour voir le style d’une carte, il faut au moins une idée enregistrée.

PROMPT US 5 -- AI utiliser CLAUDE nb requête 1 :

je suis en train de développer une petit application (boite à idée) je m'occupe actuellement de la base de donnée. voici la table :

CREATE TABLE IF NOT EXISTS info (
id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
title VARCHAR(100) NOT NULL,
description TEXT NOT NULL,
pseudo VARCHAR(50) NOT NULL,
createDate DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
nbVote INT NOT NULL DEFAULT 0
) ENGINE = InnoDB;

insert moi dans la table 20 valeur.
je veux des accent, texte long, accent et des vote variés. il ne faut pas de vrai nom / email




## prompt us 14

Fais un audit de sécurité de mon application « boîte à idées » 
Je t'envoie mon code, sans le fichier config.php 

Vérifie : injection SQL, XSS, validation des champs, CSRF, sessions, fichiers sensibles accessibles par URL (.git, sql/).

Donne-moi un tableau : problème, fichier, gravité (élevée / moyenne / faible), test pour le reproduire, correction proposée.
Sépare les vraies failles des simples améliorations, et explique en une phrase pourquoi chaque point est un risque.
Ne réécris pas tout mon code.

## prompt us 3 et 4

fais une relecture de l'us 4 ainsique que de l'us 3, fais moi un compte rendu detailler sur WORD, donne moi les axes d'ameliorations. dis moi si les fichiers comporte des risques faible/modéré/elevé le tout classé dans un tableau. ne modifi pas mon code
