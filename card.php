<?php

// recupere la base de donné
require_once __DIR__ . '/includes/db.php';

function get_card(){

$pdo = getPDO();
$query = $pdo->prepare("SELECT createDate as date, 
                                description as descri, 
                                nbVote as vote, 
                                pseudo as pseudo, 
                                title as title from info;");

    $query->execute();
    return $query->fetchAll();
}

