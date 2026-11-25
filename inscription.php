<?php
require_once __DIR__ . '/config.php';

$erreur = '';
$id = null;
$pseudo = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo = textePost('pseudo');
    if (!csrfValide()) {
        $erreur = 'Requête invalide. Actualise la page.';
    } elseif (!longueurValide($pseudo, 3, 50)) {
        $erreur = 'Le pseudo doit contenir entre 3 et 50 caractères.';
    } else {
        try {
            $pdo = getPDO();
            $stmt = $pdo->prepare('INSERT INTO users (pseudo) VALUES (?)');
            $stmt->execute([$pseudo]);
            $id = $pdo->lastInsertId();
        } catch (PDOException $e) {
            if ((int) ($e->errorInfo[1] ?? 0) === 1062) {
                $erreur = 'Ce pseudo existe déjà.';
            } else {
                $erreur = erreurMySQL($e);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - IdeaBox</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <h1>Créer un compte</h1>
    <?php if ($erreur !== ''): ?>
        <p role="alert"><?= e($erreur) ?></p>
    <?php endif; ?>
    <?php if ($id !== null): ?>
        <h2>Compte créé !</h2>
        <p>Ton pseudo : <?= e($pseudo) ?></p>
        <p>Ton ID : <?= e($id) ?></p>
        <p>Garde bien ton ID pour te connecter.</p>
        <a href="connection.php">Se connecter</a>
    <?php else: ?>
        <form method="POST">
            <input type="hidden" name="csrf_token" value="<?= e($_SESSION['csrf_token']) ?>">
            <input type="text" name="pseudo" placeholder="Choisis un pseudo" value="<?= e($pseudo) ?>" minlength="3" maxlength="50" required>
            <button type="submit">Créer mon compte</button>
        </form>
    <?php endif; ?>
    <p><a href="index.php">Retour aux idées</a></p>
</body>
</html>
