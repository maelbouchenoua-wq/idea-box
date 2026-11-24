# Revue de sécurité des US 3 et 4

**IdeaBox · 24 novembre 2026**

Une idée validée est destinée à la promo. Son titre, son pseudo et sa description apparaissent dans la liste pour toute personne qui peut ouvrir la page. Une idée refusée doit rester dans le formulaire de la personne qui la corrige. Les identifiants MySQL ne sont pas nécessaires aux visiteurs.

## Ce qui a été corrigé

La première version écrivait le message complet du pilote MySQL dans le journal lors d’un échec de connexion. Une erreur pendant la lecture des cartes pouvait aussi interrompre la page sans traitement. Enfin, une panne de connexion renvoyait le statut HTTP 200, habituellement associé à une réussite.

La lecture et l’enregistrement traitent maintenant ces erreurs. La page explique que la liste ou l’enregistrement est momentanément indisponible et renvoie HTTP 503. Le journal de l’application indique seulement quelle opération a échoué. Les textes saisis et les détails de connexion ne sont pas inclus dans ces messages.

La page demande aussi au navigateur et aux caches intermédiaires de ne pas conserver sa réponse (`Cache-Control: no-store`). Sur une saisie invalide, PHP reprend les valeurs dans la réponse à l’envoi en cours. La session ne sert qu’à afficher une fois la confirmation d’une insertion réussie.

## Vérification de Git

Le fichier local `includes/config.php` est ignoré et absent de l’index Git actuel. Le modèle destiné aux collègues laisse le mot de passe vide. Le fichier réel de connexion du poste a été laissé intact.

Une ancienne version de `includes/config.php` est toujours présente dans l’historique Git local. Un contrôle automatique a lu la déclaration `DB_PASS` sans exécuter l’ancien fichier ni afficher sa valeur. Elle était vide dans l’unique version retrouvée à ce chemin. Cette vérification concerne l’historique local disponible et ce champ précis.

## Ce qui a été testé

Les tests ont utilisé deux sessions indépendantes, des idées et des identifiants fictifs, PHP 8.4.27 et une base temporaire MariaDB 11.4.8. L’affichage des erreurs PHP était activé. Le réglage automatique du cache des sessions était désactivé pour vérifier que le formulaire envoyait lui-même sa consigne de confidentialité.

| Essai | Résultat observé |
| --- | --- |
| Envoyer un brouillon avec un titre vide et une description contenant des guillemets, un chevron et une esperluette | L’auteur retrouve son texte dans le formulaire et peut le corriger. L’autre session ne le voit pas. Aucune ligne en base, aucune copie du brouillon dans les fichiers de session. La réponse contient `Cache-Control: no-store`. |
| Envoyer un titre au-delà de la limite | Le serveur refuse l’envoi avec HTTP 422. Une ouverture directe du traitement en GET renvoie HTTP 405. |
| Envoyer une idée valide avec des accents et des caractères spéciaux | La requête préparée enregistre le texte à l’identique, avec la date du jour et zéro vote. La carte affiche les caractères comme du texte. Les deux visiteurs peuvent lire la carte et seul l’auteur reçoit la confirmation, une fois. |
| Retirer le droit de lecture, puis le droit d’écriture, chacun dans un essai distinct | Chaque opération concernée renvoie HTTP 503 avec un message compréhensible. L’insertion refusée laisse intact le nombre de lignes. |
| Tester une configuration absente ou incomplète, puis une base arrêtée | Lecture et enregistrement renvoient HTTP 503 dans chacun des trois cas. Une tentative de connexion avec des identifiants de test refusés donne aussi une réponse générique. Une saisie invalide reste corrigeable avec HTTP 422 même quand la base est arrêtée. |
| Examiner les pages d’erreur et les journaux produits pendant les essais | Aucun des identifiants, mots de passe ou textes fictifs recherchés n’est apparu dans les journaux PHP et HTTP. Les neuf réponses 503 ne contenaient ni ces données ni les chemins locaux ou diagnostics techniques recherchés. |

Ces observations couvrent le parcours local de création et de correction d’une idée. Elles peuvent être jointes au rendu comme preuves des vérifications réalisées par Codex.
