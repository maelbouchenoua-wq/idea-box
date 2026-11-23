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




