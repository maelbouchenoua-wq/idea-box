<?php
session_start();

header('Content-Type: application/json; charset=utf-8');

// Vérifier que l'utilisateur est connecté
if (empty($_SESSION['pseudo'])) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'message' => 'Connecte-toi pour voter.'
    ]);
    exit;
}

// Vérifier la méthode HTTP
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit;
}

// Vérifier le token CSRF
if (
    empty($_POST['csrf_token']) ||
    empty($_SESSION['csrf_token']) ||
    !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
) {
    http_response_code(403);
    echo json_encode([
        'success' => false,
        'message' => 'Requête invalide.'
    ]);
    exit;
}

// Connexion à la base de données
require_once 'connexion.php';

// Récupérer les informations
$pseudo = $_SESSION['pseudo'];
$infoId = filter_input(INPUT_POST, 'info_id', FILTER_VALIDATE_INT);

if (!$infoId || $infoId <= 0) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Publication invalide.'
    ]);
    exit;
}

try {

    $pdo->beginTransaction();

    // Vérifier que la publication existe
    $check = $pdo->prepare(
        "SELECT id FROM info WHERE id = ?"
    );

    $check->execute([$infoId]);

    if (!$check->fetch()) {
        $pdo->rollBack();

        http_response_code(404);
        echo json_encode([
            'success' => false,
            'message' => 'Publication introuvable.'
        ]);
        exit;
    }

    // Enregistrer le vote
    // INSERT IGNORE évite les doublons grâce à UNIQUE
    $stmt = $pdo->prepare("
        INSERT IGNORE INTO votes (info_id, pseudo)
        VALUES (?, ?)
    ");

    $stmt->execute([$infoId, $pseudo]);

    $nouveauVote = ($stmt->rowCount() === 1);

    if ($nouveauVote) {

        // Ajouter +1 au compteur
        $update = $pdo->prepare("
            UPDATE info
            SET nbVote = nbVote + 1
            WHERE id = ?
        ");

        $update->execute([$infoId]);

        $message = 'Merci pour ton vote !';

    } else {

        $message = 'Tu as déjà voté pour cette publication.';

    }

    // Récupérer le nombre actuel de votes
    $count = $pdo->prepare("
        SELECT nbVote FROM info WHERE id = ?
    ");

    $count->execute([$infoId]);

    $total = (int) $count->fetchColumn();

    $pdo->commit();

    echo json_encode([
        'success' => $nouveauVote,
        'message' => $message,
        'nbVote' => $total
    ]);

} catch (Exception $e) {

    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    http_response_code(500);

    echo json_encode([
        'success' => false,
        'message' => 'Une erreur est survenue.'
    ]);
}