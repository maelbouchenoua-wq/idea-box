<?php
session_start();
require_once __DIR__ . '/card.php';

$tri = $_POST['tri'] ?? 'recent';
$cards = get_card($tri);

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
        <form class="container_formulaire">

            <input type="text" placeholder="Pseudo" class="rentrer le pseudo">

            <input type="text" placeholder="Titre" class="title">

            <input type="text" placeholder="Date" class="date">

            <input type="text" placeholder="Description" class="description">
            <button class="ajout">
                Ajouter
            </button>
        </form>
    </div>
    <form method="post" class="btntrie-form">
        <button class="btntrie" type="submit" name="tri" value="vote">
            LES PLUS VOTÉES
        </button>

        <button class="btntrie" type="submit" name="tri" value="recent">
            LES PLUS RÉCENTES
        </button>
    </form>
</header>

<div class="carte_idees">
    <?php if (empty($cards)): ?>
        <p class="aucune-idee">Aucune idée pour l'instant</p>
    <?php else: ?>
        <?php foreach ($cards as $card): ?>
            <div class="carte">
                <p class="carte-pseudo"><?= htmlspecialchars($card['pseudo']) ?></p>
                <p class="carte-titre"><?= htmlspecialchars($card['title']) ?></p>
                <p class="carte-date"><?= htmlspecialchars($card['date']) ?></p>
                <p class="carte-description"><?= htmlspecialchars($card['descri']) ?></p>
                <div class="carte-footer">
                    <button class="btn-vote" type="button">
                        <span class="btn-vote__icone">▲</span>
                        <span class="btn-vote__nb"><?= (int) $card['vote'] ?></span>
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

</body>




