<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
// On demande au navigateur de ne pas garder une copie du formulaire rempli.
header('Cache-Control: no-store');
require_once __DIR__ . '/includes/validation-idee.php';
// Après un refus, le formulaire retrouve ici les messages et les valeurs que la personne a tapées.
// Dans les champs, htmlspecialchars() affiche les guillemets et les chevrons comme du texte.
$erreurs ??= [];
$saisie ??= [];
if (!$erreurs) {
    require_once __DIR__ . '/card.php';
    try {
        $cards = get_card();
    } catch (Throwable) {
        error_log('IdeaBox : lecture des idées indisponible.');
        http_response_code(503);
        $cards = null;
    }
}
// On lit puis on efface la confirmation pour qu’elle ne s’affiche qu’une fois.
$ideeEnregistree = !$erreurs && ($_SESSION['idee_enregistree'] ?? false);
unset($_SESSION['idee_enregistree']);

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IdeaBox</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
<header>
    <div class="formulaire">
        <form class="container_formulaire" method="post" action="enregistrer-idee.php">

            <div>
                <label for="pseudo">Pseudo</label>
                <input type="text" id="pseudo" class="rentrer le pseudo" name="pseudo" required
                       maxlength="<?= LIMITES_IDEE['pseudo'] ?>"
                       value="<?= htmlspecialchars($saisie['pseudo'] ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>"
                       aria-invalid="<?= isset($erreurs['pseudo']) ? 'true' : 'false' ?>"
                       aria-describedby="erreur-pseudo">
                <span id="erreur-pseudo"><?= $erreurs['pseudo'] ?? '' ?></span>
            </div>
            <div>
                <label for="titre">Titre</label>
                <input type="text" id="titre" class="title" name="title" required
                       maxlength="<?= LIMITES_IDEE['title'] ?>"
                       value="<?= htmlspecialchars($saisie['title'] ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>"
                       aria-invalid="<?= isset($erreurs['title']) ? 'true' : 'false' ?>"
                       aria-describedby="erreur-title">
                <span id="erreur-title"><?= $erreurs['title'] ?? '' ?></span>
            </div>
            <div>
                <label for="description">Description</label>
                <textarea id="description" class="description" name="description" required
                          maxlength="<?= LIMITES_IDEE['description'] ?>"
                          aria-invalid="<?= isset($erreurs['description']) ? 'true' : 'false' ?>"
                          aria-describedby="erreur-description">
<?= htmlspecialchars($saisie['description'] ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></textarea>
                <span id="erreur-description"><?= $erreurs['description'] ?? '' ?></span>
            </div>
            <button class="ajout">
                Ajouter
            </button>
        </form>
    </div>
</header>

<?php if (!$erreurs): ?>
    <section id="idees">
        <?php if ($ideeEnregistree): ?>
            <p role="status">Ton idée a bien été enregistrée.</p>
        <?php endif; ?>
        <div class="carte_idees">

            <?php if ($cards === null): ?>
                <p role="alert">La liste des idées est momentanément indisponible.</p>
            <?php elseif (empty($cards)): ?>
                <p class="aucune-idee">Aucune idée pour l'instant</p>
            <?php else: ?>
                <?php foreach ($cards as $card): ?>
                    <div class="carte">
                        <p class="carte-pseudo"><?= htmlspecialchars($card['pseudo'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></p>
                        <p class="carte-titre"><?= htmlspecialchars($card['title'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></p>
                        <p class="carte-date"><?= htmlspecialchars($card['date'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></p>
                        <p class="carte-description"><?= htmlspecialchars($card['descri'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></p>
                        <div class="carte-footer">
                            <button class="btn-vote" type="button">
                                <span class="btn-vote__icone">▲</span>
                                <span class="btn-vote__nb"><?= (int)$card['vote'] ?></span>
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>

</body>




