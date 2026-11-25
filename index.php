<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/card.php';

$userId = (int) ($_SESSION['user_id'] ?? 0);
$connecte = $userId > 0 && isset($_SESSION['pseudo']);
$erreur = '';
$titre = '';
$description = '';

try {
    $pdo = getPDO();

    // Ajouter une idée avec le pseudo du compte et la date automatique de MySQL.
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $titre = textePost('title');
        $description = textePost('description');
        if (!$connecte) {
            $erreur = 'Connecte-toi pour ajouter une idée.';
        } elseif (!csrfValide()) {
            $erreur = 'Requête invalide. Actualise la page.';
        } elseif (!longueurValide($titre, 1, 100) || !longueurValide($description, 1, 16000)) {
            $erreur = 'Renseigne un titre de 1 à 100 caractères et une description de 1 à 16 000 caractères.';
        } else {
            $stmt = $pdo->prepare('INSERT INTO info (title, description, pseudo) VALUES (?, ?, ?)');
            $stmt->execute([$titre, $description, $_SESSION['pseudo']]);
            header('Location: index.php', true, 303);
            exit;
        }
    }

    $cards = get_card($connecte ? $userId : 0);
} catch (PDOException $e) {
    http_response_code(500);
    exit(e(erreurMySQL($e)));
}
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
    <?php if ($connecte): ?>
        <p>Bienvenue <?= e($_SESSION['pseudo']) ?> !</p>
        <form action="deconnexion.php" method="POST">
            <input type="hidden" name="csrf_token" value="<?= e($_SESSION['csrf_token']) ?>">
            <button type="submit">Déconnexion</button>
        </form>
    <?php else: ?>
        <a href="connection.php">Connexion</a>
        <a href="inscription.php">Inscription</a>
    <?php endif; ?>

    <header>
        <div class="formulaire">
            <?php if ($erreur !== ''): ?>
                <p role="alert"><?= e($erreur) ?></p>
            <?php endif; ?>
            <form class="container_formulaire" method="POST" action="index.php">
                <input type="hidden" name="csrf_token" value="<?= e($_SESSION['csrf_token']) ?>">
                <input type="text" placeholder="Pseudo" class="rentrer le pseudo" value="<?= e($_SESSION['pseudo'] ?? '') ?>" readonly>
                <input type="text" name="title" placeholder="Titre" class="title" maxlength="100" value="<?= e($titre) ?>" required <?= $connecte ? '' : 'disabled' ?>>
                <input type="text" placeholder="Date automatique" class="date" readonly>
                <input type="text" name="description" placeholder="Description" class="description" maxlength="16000" value="<?= e($description) ?>" required <?= $connecte ? '' : 'disabled' ?>>
                <button class="ajout" type="submit" <?= $connecte ? '' : 'disabled' ?>>Ajouter</button>
            </form>
            <?php if (!$connecte): ?>
                <p>Connecte-toi pour ajouter une idée ou voter.</p>
            <?php endif; ?>
        </div>
    </header>

    <p id="message-vote" role="status" aria-live="polite"></p>
    <div class="carte_idees">
        <?php if (empty($cards)): ?>
            <p class="aucune-idee">Aucune idée pour l'instant</p>
        <?php else: ?>
            <?php foreach ($cards as $card): ?>
                <div class="carte">
                    <p class="carte-pseudo"><?= e($card['pseudo']) ?></p>
                    <p class="carte-titre"><?= e($card['title']) ?></p>
                    <p class="carte-date"><?= e($card['createDate']) ?></p>
                    <p class="carte-description"><?= e($card['description']) ?></p>
                    <div class="carte-footer">
                        <button
                            class="btn-vote <?= !empty($card['dejaVote']) ? 'voted' : '' ?>"
                            type="button"
                            data-info-id="<?= (int) $card['id'] ?>"
                            aria-label="Voter pour cette idée"
                            <?= (!$connecte || !empty($card['dejaVote'])) ? 'disabled' : '' ?>
                        >
                            <span class="btn-vote__icone">▲</span>
                            <span class="btn-vote__nb"><?= (int) $card['nbVote'] ?></span>
                            <span class="btn-vote__plus">+1</span>
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <script>
        const csrfToken = <?= json_encode($_SESSION['csrf_token']) ?>;
        const messageVote = document.getElementById('message-vote');

        document.querySelectorAll('.btn-vote').forEach((button) => {
            button.addEventListener('click', async () => {
                if (button.disabled) return;
                button.disabled = true;
                messageVote.textContent = '';

                try {
                    const response = await fetch('vote.php', {
                        method: 'POST',
                        credentials: 'same-origin',
                        body: new URLSearchParams({
                            info_id: button.dataset.infoId,
                            csrf_token: csrfToken
                        })
                    });
                    const data = await response.json();
                    messageVote.textContent = data.message || 'Réponse inattendue.';

                    if (Number.isInteger(data.nbVote)) {
                        button.querySelector('.btn-vote__nb').textContent = data.nbVote;
                    }
                    if (response.ok && data.dejaVote === true) {
                        button.classList.add('voted');
                    } else {
                        button.disabled = false;
                    }
                } catch (error) {
                    messageVote.textContent = 'Impossible de voter. Vérifie la connexion et réessaie.';
                    button.disabled = false;
                }
            });
        });
    </script>
</body>
</html>
