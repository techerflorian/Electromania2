<?php

/**
 * Classe Logger - Enregistre les erreurs dans des fichiers
 * 
 * Utilisation:
 * Logger::error("Une erreur est survenue");
 * Logger::warning("Attention!");
 * Logger::info("Information");
 */
class Logger
{
    const LEVEL_DEBUG = 'DEBUG';
    const LEVEL_INFO = 'INFO';
    const LEVEL_WARNING = 'WARNING';
    const LEVEL_ERROR = 'ERROR';
    const LEVEL_CRITICAL = 'CRITICAL';

    private static string $logDir = '';

    /**
     * Initialise le répertoire des logs
     */
    public static function init(string $logDir): void
    {
        self::$logDir = $logDir;
        
        // Créer le répertoire s'il n'existe pas
        if (!is_dir(self::$logDir)) {
            mkdir(self::$logDir, 0755, true);
        }
    }

    /**
     * Enregistre un message d'erreur
     */
    public static function error(string $message, array $context = []): void
    {
        self::log(self::LEVEL_ERROR, $message, $context);
    }

    /**
     * Enregistre une erreur critique
     */
    public static function critical(string $message, array $context = []): void
    {
        self::log(self::LEVEL_CRITICAL, $message, $context);
    }

    /**
     * Enregistre un avertissement
     */
    public static function warning(string $message, array $context = []): void
    {
        self::log(self::LEVEL_WARNING, $message, $context);
    }

    /**
     * Enregistre une information
     */
    public static function info(string $message, array $context = []): void
    {
        self::log(self::LEVEL_INFO, $message, $context);
    }

    /**
     * Enregistre un message de debug
     */
    public static function debug(string $message, array $context = []): void
    {
        if (APP_ENV === 'development') {
            self::log(self::LEVEL_DEBUG, $message, $context);
        }
    }

    /**
     * Enregistre un message avec niveau spécifié
     */
    private static function log(string $level, string $message, array $context = []): void
    {
        $timestamp = date('Y-m-d H:i:s');
        $file = self::$logDir . '/' . date('Y-m-d') . '.log';
        
        // Formater le message
        $logMessage = "[$timestamp] [$level] $message";
        
        // Ajouter le contexte s'il existe
        if (!empty($context)) {
            $logMessage .= " " . json_encode($context);
        }
        
        // Ajouter la trace de la requête
        $logMessage .= " [" . $_SERVER['REQUEST_METHOD'] . " " . $_SERVER['REQUEST_URI'] . "]";
        
        // Ajouter l'IP du client
        $ip = self::getClientIp();
        if ($ip) {
            $logMessage .= " [IP: $ip]";
        }
        
        $logMessage .= "\n";
        
        // Écrire dans le fichier
        error_log($logMessage, 3, $file);
    }

    /**
     * Récupère l'adresse IP du client
     */
    private static function getClientIp(): string
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
        } else {
            return $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';
        }
    }

    /**
     * Retourne les derniers logs
     */
    public static function getLast(int $lines = 50): array
    {
        $file = self::$logDir . '/' . date('Y-m-d') . '.log';
        
        if (!file_exists($file)) {
            return [];
        }
        
        $allLines = file($file, FILE_IGNORE_NEW_LINES);
        return array_slice($allLines, -$lines);
    }
}
