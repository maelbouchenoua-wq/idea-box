<?php
require_once __DIR__ . '/config.php';

$erreur = '';
$pseudo = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo = textePost('pseudo');
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

    if (!csrfValide()) {
        $erreur = 'Requête invalide. Actualise la page.';
    } elseif (!$id || $id <= 0 || !longueurValide($pseudo, 3, 50)) {
        $erreur = 'Pseudo ou ID invalide.';
    } else {
        try {
            $stmt = getPDO()->prepare('SELECT id, pseudo FROM users WHERE id = ? AND pseudo = ?');
            $stmt->execute([$id, $pseudo]);
            $user = $stmt->fetch();

            if ($user) {
                session_regenerate_id(true);
                $_SESSION['user_id'] = (int) $user['id'];
                $_SESSION['pseudo'] = $user['pseudo'];
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
                header('Location: index.php', true, 303);
                exit;
            }
            $erreur = 'Pseudo ou ID incorrect.';
        } catch (PDOException $e) {
            $erreur = erreurMySQL($e);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - IdeaBox</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <h1>Connexion</h1>
    <?php if ($erreur !== ''): ?>
        <p style="color:red" role="alert"><?= e($erreur) ?></p>
    <?php endif; ?>
    <form method="POST">
        <input type="hidden" name="csrf_token" value="<?= e($_SESSION['csrf_token']) ?>">
        <input type="text" name="pseudo" placeholder="Ton pseudo" value="<?= e($pseudo) ?>" maxlength="50" required>
        <input type="number" name="id" placeholder="Ton ID" min="1" required>
        <button type="submit">Se connecter</button>
    </form>
    <p>Pas encore de compte ? <a href="inscription.php">S'inscrire</a></p>
    <p><a href="index.php">Retour aux idées</a></p>
</body>
</html>
