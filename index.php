<?php
session_start();
require_once __DIR__ . '/card.php';
$cards = get_card();

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IdeaBox</title>
    <link rel="stylesheet" href="assets/css/styles.css">

    <link rel="stylesheet" href="assets/css/cartes.css">

</head>

<body>
<header class="formulaire">
    <form class="container_formulaire">

        <input class="rentrer le pseudo">
        Pseudo
        </input>


        <input class="title">
        Titre
        </input>

        <input class="date">
        Date
        </input>

        <input class="description">
        Description
        </input>
        <button class="ajout">
            Ajouter
        </button>
    </form>
</header>

<section class="container_idees">
    <div class="container_cartes">
        <div class="carte_idees">
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
        </div>
    </div>
</section>

>>>>>>> Stashed changes
</body>




