# US 3 — Enregistrer une idée

**24 novembre 2026 · IdeaBox · Codex (GPT-6)**

## Travail réalisé

Codex a écrit le traitement à la demande de l’utilisateur, puis effectué une relecture. Le mode prévu par le backlog est « Je code, l’IA relit ». Cette version ne permet donc pas d’attester une première rédaction personnelle. Les décisions et les vérifications ci-dessous sont celles de Codex.

**Demande reçue**

> Ok bah nickel, bah écoute, vas-y tu me codes ça, tu crées les fichiers, t'es tout ça. Moi je te valide et vas-y balance ça sur sur dans le projet. Mais voilà tu ne push rien, tu ne merges pas. C'est moi qui m'en occupe

Dans `index.php`, le formulaire envoie le titre, la description et le pseudo à `enregistrer-idee.php`. Ce fichier réutilise `getPDO()`, prépare l’insertion et passe les valeurs à `execute()`. MySQL attribue la date et le nombre initial de votes. Après la réussite de l’insertion, le navigateur revient sur la liste en GET et la session permet d’afficher la confirmation une seule fois.

## Relecture

La relecture a porté sur le formulaire, le traitement d’enregistrement, la fonction de connexion, le modèle de configuration et le schéma SQL. La configuration locale a été exclue de la relecture.

| Remarque | Décision et raison |
| --- | --- |
| Git suivait déjà `includes/config.php`. | Corrigée. Le fichier a été retiré de l’index et ajouté au `.gitignore`. La copie locale a été conservée et son intégrité vérifiée. Pour une nouvelle installation, copier `includes/config.example.php` vers `includes/config.php`, puis y renseigner les accès locaux. |
| Actualiser la page après un envoi risque de soumettre de nouveau le formulaire. | Le traitement renvoie une redirection HTTP 303 après l’insertion. L’actualisation recharge la liste en GET. |
| Les limites du titre et du pseudo sont indiquées dans le formulaire. | Le traitement vérifie que les trois champs reçus sont des textes non vides. Le contrôle détaillé des longueurs côté PHP et les erreurs par champ sont prévus à l’US 4. |
| Lors de la première relecture, la connexion commune utilisait `die()` en cas d’indisponibilité de MySQL. | La première version gérait les erreurs d’INSERT. La revue complémentaire de sécurité a ensuite traité les pannes de connexion et de lecture. |

Le retrait du suivi Git agit sur les prochains commits. Si un véritable mot de passe a été partagé dans un ancien commit, il doit être renouvelé. Les collègues qui utilisent leur propre `config.php` peuvent en garder une copie avant de récupérer ce changement.

## Tests et résultats

Le parcours a été vérifié en HTTP avec PHP 8.4.27 et une base temporaire MariaDB 11.4.8 utilisant `sql/schema.sql`. Une idée fictive existait avant le test. Aucun essai n’a écrit dans la base de l’équipe.

| Vérification | Résultat observé |
| --- | --- |
| Soumettre le formulaire avec le titre `L'idée de Léa` | La lecture SQL retrouve exactement le titre, le pseudo `Léa` et la description `Atelier de cuisine d'équipe.`. La date est le 24/11/2026, date du serveur au moment du test, et le nombre de votes vaut 0. |
| Suivre la redirection | Réponse 303 vers `index.php#idees`. La liste contient l’ancienne et la nouvelle carte. Le message « Ton idée a bien été enregistrée. » apparaît dans la session de l’auteur. |
| Actualiser ou ouvrir une autre session | La confirmation disparaît après le premier affichage. L’autre session ne la reçoit pas. Le nombre d’idées reste à deux. |
| Appeler directement le traitement en GET | Réponse 405 indiquant que POST est la méthode admise. |
| Envoyer un formulaire incomplet | Réponse 422. Aucune ligne ajoutée. |
| Rendre l’insertion impossible sur la base de test | Réponse 503, message générique et toujours deux lignes. |
| Arrêter entièrement la base de test (première version) | Le composant partagé affichait « Erreur de connexion à la base de données. » et renvoyait HTTP 200. Le résultat du nouvel essai figure dans la revue complémentaire. |
| Vérifier la configuration Git | `git check-ignore` retrouve la règle. La configuration reste présente sur le disque et ne figure plus dans l’index Git local. |

## Revue complémentaire de sécurité

Les contrôles de confidentialité de l’enregistrement et les nouveaux essais de panne sont documentés dans le [bilan de sécurité des US 3 et 4](US03-US04-securite.md).
