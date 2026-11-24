<?php
session_start();
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
</header>
<section class="container_idees">
    <div class="container_cartes">
        <div class="carte_idees">
            <div class="carte">
                <p class="carte-pseudo">Pseudo</p>
                <p class="carte-titre">Titre</p>
                <p class="carte-date">Date</p>
                <p class="carte-description">Description</p>
                <div class="carte-footer">
                    <button class="btn-vote" type="button">
                        <span class="btn-vote__icone">▲</span>
                        <span class="btn-vote__nb">12</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

</body>




