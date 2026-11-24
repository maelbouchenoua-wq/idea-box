<?php

// recupere la base de donné
require_once __DIR__ . '/includes/db.php';

require_once __DIR__ . '/includes/db.php';

function get_card($tri = 'recent')
{
    $pdo = getPDO();

    // Si le bouton "LES PLUS VOTÉES" a été cliqué,
    // on trie par nombre de votes, du plus grand au plus petit.
    if ($tri === 'vote') {
        $ordre = 'nbVote DESC';
    } else {
        // Pour "recent" (ou une autre valeur),
        // on trie par date, de la plus récente à la plus ancienne.
        $ordre = 'createDate DESC';
    }
    $query = $pdo->prepare("
        SELECT createDate AS date,
               description AS descri,
               nbVote AS vote,
               pseudo,
               title
        FROM info
        ORDER BY $ordre
    ");

    $query->execute();
    return $query->fetchAll();
}