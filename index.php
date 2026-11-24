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
<section class="container_idées">
    <div classe="container_cartes">
        <div class="carte_idées">
            <div class="carte">
                <p>
                    Pseudo
                </p>
                <p>
                    titre
                </p>
                <p>
                    Date
                </p>
                <p>
                    description
                </p>


            </div>
        </div>

    </div>
</section>


</body>




