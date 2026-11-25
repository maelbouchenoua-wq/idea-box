<?php
// Réglages MySQL de MAMP : adapte le port et les identifiants si nécessaire.
if (!defined('DB_HOST')) define('DB_HOST', '127.0.0.1');
if (!defined('DB_PORT')) define('DB_PORT', 8889);
if (!defined('DB_NAME')) define('DB_NAME', 'box');
if (!defined('DB_USER')) define('DB_USER', 'root');
if (!defined('DB_PASSWORD')) define('DB_PASSWORD', 'root');
if (!defined('DB_CHARSET')) define('DB_CHARSET', 'utf8mb4');

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

function getPDO(): PDO
{
    static $pdo = null;
    if ($pdo === null) {
        $pdo = new PDO(
            'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET,
            DB_USER,
            DB_PASSWORD,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]
        );
    }
    return $pdo;
}

function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function csrfValide(): bool
{
    $token = $_POST['csrf_token'] ?? null;
    return is_string($token) && hash_equals($_SESSION['csrf_token'], $token);
}

function textePost(string $name): string
{
    $value = $_POST[$name] ?? '';
    return is_string($value) ? trim($value) : '';
}

function longueurValide(string $text, int $min, int $max): bool
{
    $length = preg_match_all('/./us', $text);
    return $length !== false && $length >= $min && $length <= $max;
}

// Indique la cause probable sans afficher les identifiants de connexion.
function erreurMySQL(PDOException $exception): string
{
    error_log($exception->getMessage());
    $code = (int) ($exception->errorInfo[1] ?? 0);
    if (strpos($exception->getMessage(), 'could not find driver') !== false) {
        return 'Le pilote PHP pdo_mysql est absent. Vérifie que tu utilises le PHP de MAMP.';
    }
    switch ($code) {
        case 1044:
        case 1045:
            return 'Accès MySQL refusé : vérifie DB_USER et DB_PASSWORD dans config.php.';
        case 1049:
            return 'Base box introuvable : importe database.sql dans phpMyAdmin.';
        case 1054:
            return 'Colonne MySQL manquante : vérifie notamment votes.user_id et la structure de database.sql.';
        case 1146:
            return 'Table MySQL manquante : importe database.sql dans phpMyAdmin.';
        case 2002:
        case 2003:
            return 'Connexion MySQL impossible : démarre MAMP et vérifie DB_HOST et DB_PORT dans config.php.';
        case 1452:
            return 'Compte ou idée introuvable : reconnecte-toi et vérifie la structure de la base.';
        default:
            return 'Erreur MySQL : consulte le journal PHP de MAMP et vérifie database.sql.';
    }
}
