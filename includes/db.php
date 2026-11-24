<?php
if (!function_exists('getPDO')) {

    function getPDO(): PDO
    {
        // Pendant la même requête, les appels suivants réutilisent la connexion déjà ouverte.
        static $pdo = null;

        if ($pdo === null) {
            // Chaque membre de l’équipe garde ses propres codes de connexion dans ce fichier local.
            $config = __DIR__ . '/config.php';
            if (!is_file($config) || !is_readable($config)) {
                throw new RuntimeException('Configuration MySQL indisponible.');
            }
            require_once $config;

            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";

            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ];

            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        }

        return $pdo;
    }

}
