<?php
header('Content-Type: application/json; charset=utf-8');

function reponseVote(int $status, array $data): void
{
    http_response_code($status);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
}

$pdo = null;
try {
    require_once __DIR__ . '/config.php';
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Allow: POST');
        reponseVote(405, ['success' => false, 'message' => 'Méthode non autorisée.']);
        exit;
    }
    $userId = (int) ($_SESSION['user_id'] ?? 0);
    if ($userId <= 0) {
        reponseVote(401, ['success' => false, 'message' => 'Connecte-toi pour voter.']);
        exit;
    }
    if (!csrfValide()) {
        reponseVote(403, ['success' => false, 'message' => 'Requête invalide. Actualise la page.']);
        exit;
    }
    $infoId = filter_input(INPUT_POST, 'info_id', FILTER_VALIDATE_INT);
    if (!$infoId || $infoId <= 0) {
        reponseVote(400, ['success' => false, 'message' => 'Publication invalide.']);
        exit;
    }

    $pdo = getPDO();
    $pdo->beginTransaction();

    // Verrouille cette idée pendant le vote : le compteur reste cohérent.
    $check = $pdo->prepare('SELECT nbVote FROM info WHERE id = ? FOR UPDATE');
    $check->execute([$infoId]);
    $total = $check->fetchColumn();
    if ($total === false) {
        $pdo->rollBack();
        reponseVote(404, ['success' => false, 'message' => 'Publication introuvable.']);
        exit;
    }

    // UNIQUE (info_id, user_id) bloque les doublons même côté serveur.
    $nouveauVote = true;
    try {
        $stmt = $pdo->prepare('INSERT INTO votes (info_id, user_id) VALUES (?, ?)');
        $stmt->execute([$infoId, $userId]);
    } catch (PDOException $e) {
        if ((int) ($e->errorInfo[1] ?? 0) !== 1062) {
            throw $e;
        }
        $nouveauVote = false;
    }

    if ($nouveauVote) {
        $update = $pdo->prepare('UPDATE info SET nbVote = nbVote + 1 WHERE id = ?');
        $update->execute([$infoId]);
    }

    $count = $pdo->prepare('SELECT nbVote FROM info WHERE id = ?');
    $count->execute([$infoId]);
    $total = (int) $count->fetchColumn();
    $pdo->commit();

    reponseVote(200, [
        'success' => $nouveauVote,
        'dejaVote' => true,
        'message' => $nouveauVote ? 'Merci pour ton vote !' : 'Tu as déjà voté pour cette publication.',
        'nbVote' => $total,
    ]);
} catch (Throwable $e) {
    if ($pdo instanceof PDO && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    if ($e instanceof PDOException) {
        $message = erreurMySQL($e);
    } else {
        error_log($e->getMessage());
        $message = 'Erreur du serveur. Consulte le journal PHP de MAMP.';
    }
    reponseVote(500, ['success' => false, 'message' => $message]);
}
