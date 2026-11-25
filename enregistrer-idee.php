<?php
// Le bouton « Ajouter » envoie le titre, la description et le pseudo en POST à cette page
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Allow: POST');
    header('Content-Type: text/plain; charset=UTF-8');
    http_response_code(405);
    exit('Pour proposer une idée, utilise le formulaire.');
}

require_once __DIR__ . '/includes/securite.php';
require_once __DIR__ . '/includes/validation-idee.php';

// US 14 : un formulaire posté depuis un autre site n'a pas le jeton de notre session, il est refusé.
if (!jetonCsrfValide($_POST['jeton_csrf'] ?? null)) {
    header('Content-Type: text/plain; charset=UTF-8');
    http_response_code(403);
    exit('Formulaire expiré ou invalide. Recharge la page et réessaie.');
}

// On garde le texte d’origine pour le formulaire. On vérifie une copie sans les espaces du début et de la fin
$saisie = [];
$valeurs = [];
$erreurs = [];
foreach (array_keys(LIMITES_IDEE) as $champ) {
    $brut = $_POST[$champ] ?? null;
    $saisie[$champ] = is_string($brut) ? $brut : '';
    $valeurs[$champ] = trim($saisie[$champ]);
    $erreur = erreurChampIdee($champ, $valeurs[$champ]);
    if ($erreur !== null) {
        $erreurs[$champ] = $erreur;
    }
}

// Le formulaire peut afficher toutes les ereurs en seul envoi
if ($erreurs) {
    http_response_code(422);
    require __DIR__ . '/index.php';
    exit;
}

header('Cache-Control: no-store');
require_once __DIR__ . '/includes/db.php';

try {
    // execute() envoie les valeurs séparément de la commande SQL
    // La base ajoute elle même la date et fixe le nombre de votes à zéro
    $requete = getPDO()->prepare(
        'INSERT INTO info (title, description, pseudo) VALUES (:titre, :description, :pseudo)'
    );
    $requete->execute([
        'titre' => $valeurs['title'],
        'description' => $valeurs['description'],
        'pseudo' => $valeurs['pseudo'],
    ]);
} catch (Throwable) {
    // Le journal indique où l’enregistrement a échoué sans recopier l’idée ni les codes de connexion
    error_log('IdeaBox : enregistrement de l’idée indisponible.');
    header('Content-Type: text/plain; charset=UTF-8');
    http_response_code(503);
    exit('Impossible d’enregistrer ton idée pour le moment. Réessaie plus tard.');
}

$_SESSION['idee_enregistree'] = true;
// On revient sur la liste. Si la personne actulise la page, elle recharge la liste sans ajoutée de doublon
header('Location: index.php#idees', true, 303);
exit;
