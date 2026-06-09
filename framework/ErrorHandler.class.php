<?php

/**
 * Classe ErrorHandler - Gestion centralisée des erreurs
 * 
 * Capture les exceptions et les erreurs PHP
 * Affiche des messages différents selon l'environnement (dev vs production)
 * Enregistre les erreurs dans des logs
 */
class ErrorHandler
{
    /**
     * Initialise les handlers d'erreurs
     */
    public static function register(): void
    {
        // Gérer les exceptions non capturées
        set_exception_handler([self::class, 'handleException']);
        
        // Gérer les erreurs PHP
        set_error_handler([self::class, 'handleError']);
        
        // Gérer les erreurs fatales
        register_shutdown_function([self::class, 'handleShutdown']);
    }

    /**
     * Traite les exceptions
     */
    public static function handleException(Throwable $exception): void
    {
        Logger::critical(
            "Exception non capturée: " . $exception->getMessage(),
            [
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'code' => $exception->getCode()
            ]
        );

        self::displayError(
            $exception->getMessage(),
            $exception->getFile(),
            $exception->getLine(),
            $exception->getTraceAsString()
        );
    }

    /**
     * Traite les erreurs PHP
     */
    public static function handleError(
        int $severity,
        string $message,
        string $file,
        int $line
    ): bool {
        // Ne pas traiter les erreurs supprimées avec @
        if (!(error_reporting() & $severity)) {
            return false;
        }

        $levelName = self::getLevelName($severity);

        Logger::error(
            "$levelName: $message",
            [
                'file' => $file,
                'line' => $line,
                'severity' => $severity
            ]
        );

        self::displayError($message, $file, $line);

        return true;
    }

    /**
     * Traite les erreurs fatales
     */
    public static function handleShutdown(): void
    {
        $error = error_get_last();

        if ($error !== null && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
            Logger::critical(
                "Erreur fatale: " . $error['message'],
                [
                    'file' => $error['file'],
                    'line' => $error['line'],
                    'type' => $error['type']
                ]
            );

            self::displayError(
                $error['message'],
                $error['file'],
                $error['line']
            );
        }
    }

    /**
     * Affiche l'erreur selon l'environnement
     */
    private static function displayError(
        string $message,
        string $file = '',
        int $line = 0,
        string $trace = ''
    ): void {
        http_response_code(500);

        if (APP_ENV === 'development') {
            self::displayDevelopmentError($message, $file, $line, $trace);
        } else {
            self::displayProductionError();
        }

        exit(1);
    }

    /**
     * Affiche une erreur détaillée en développement
     */
    private static function displayDevelopmentError(
        string $message,
        string $file,
        int $line,
        string $trace
    ): void {
        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Erreur - <?= SITE_NOM ?></title>
            <style>
                * { margin: 0; padding: 0; box-sizing: border-box; }
                body {
                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                    background: #1e1e1e;
                    color: #e0e0e0;
                    padding: 20px;
                }
                .container {
                    max-width: 1000px;
                    margin: 0 auto;
                    background: #2d2d2d;
                    border-left: 4px solid #ff6b6b;
                    border-radius: 5px;
                    padding: 30px;
                    box-shadow: 0 10px 30px rgba(0,0,0,0.5);
                }
                h1 {
                    color: #ff6b6b;
                    margin-bottom: 10px;
                    font-size: 28px;
                }
                .message {
                    background: #3d3d3d;
                    padding: 15px;
                    border-radius: 5px;
                    margin: 20px 0;
                    border-left: 3px solid #ffa500;
                    word-break: break-all;
                }
                .file-info {
                    background: #3d3d3d;
                    padding: 15px;
                    border-radius: 5px;
                    margin: 20px 0;
                    font-family: 'Courier New', monospace;
                    font-size: 13px;
                }
                .file-info strong {
                    color: #4ecdc4;
                }
                .trace {
                    background: #1e1e1e;
                    padding: 15px;
                    border-radius: 5px;
                    margin: 20px 0;
                    max-height: 400px;
                    overflow-y: auto;
                    font-family: 'Courier New', monospace;
                    font-size: 12px;
                    color: #b0b0b0;
                    white-space: pre-wrap;
                }
                .section-title {
                    color: #4ecdc4;
                    margin-top: 30px;
                    margin-bottom: 15px;
                    font-weight: bold;
                    text-transform: uppercase;
                    font-size: 12px;
                    letter-spacing: 1px;
                }
                .env-badge {
                    display: inline-block;
                    background: #ff6b6b;
                    color: white;
                    padding: 5px 10px;
                    border-radius: 3px;
                    font-size: 12px;
                    margin-bottom: 20px;
                    font-weight: bold;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="env-badge">🔴 MODE DÉVELOPPEMENT</div>
                <h1>⚠️ Une erreur s'est produite</h1>
                
                <div class="message">
                    <strong>Message:</strong><br>
                    <?= htmlspecialchars($message) ?>
                </div>

                <div class="section-title">Localisation</div>
                <div class="file-info">
                    <strong>Fichier:</strong> <?= htmlspecialchars($file) ?><br>
                    <strong>Ligne:</strong> <?= $line ?>
                </div>

                <?php if (!empty($trace)): ?>
                <div class="section-title">Trace de la pile</div>
                <div class="trace"><?= htmlspecialchars($trace) ?></div>
                <?php endif; ?>

                <div class="section-title">Informations de la requête</div>
                <div class="file-info">
                    <strong>Méthode:</strong> <?= $_SERVER['REQUEST_METHOD'] ?><br>
                    <strong>URL:</strong> <?= htmlspecialchars($_SERVER['REQUEST_URI']) ?><br>
                    <strong>Heure:</strong> <?= date('Y-m-d H:i:s') ?>
                </div>
            </div>
        </body>
        </html>
        <?php
    }

    /**
     * Affiche une erreur générique en production
     */
    private static function displayProductionError(): void
    {
        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Erreur 500</title>
            <style>
                * { margin: 0; padding: 0; box-sizing: border-box; }
                body {
                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    min-height: 100vh;
                    padding: 20px;
                }
                .container {
                    background: white;
                    border-radius: 10px;
                    padding: 50px;
                    text-align: center;
                    box-shadow: 0 10px 40px rgba(0,0,0,0.2);
                    max-width: 500px;
                }
                h1 {
                    color: #333;
                    font-size: 48px;
                    margin-bottom: 20px;
                }
                p {
                    color: #666;
                    font-size: 18px;
                    margin-bottom: 30px;
                }
                .button {
                    display: inline-block;
                    background: #667eea;
                    color: white;
                    padding: 12px 30px;
                    text-decoration: none;
                    border-radius: 5px;
                    transition: background 0.3s;
                }
                .button:hover {
                    background: #764ba2;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <h1>500</h1>
                <p>Une erreur serveur s'est produite.</p>
                <p style="font-size: 14px; color: #999;">Notre équipe a été notifiée et travaille à la résolution du problème.</p>
                <a href="/" class="button">Retour à l'accueil</a>
            </div>
        </body>
        </html>
        <?php
    }

    /**
     * Retourne le nom du niveau d'erreur
     */
    private static function getLevelName(int $severity): string
    {
        return match ($severity) {
            E_ERROR => 'ERROR',
            E_WARNING => 'WARNING',
            E_PARSE => 'PARSE',
            E_NOTICE => 'NOTICE',
            E_CORE_ERROR => 'CORE_ERROR',
            E_CORE_WARNING => 'CORE_WARNING',
            E_COMPILE_ERROR => 'COMPILE_ERROR',
            E_COMPILE_WARNING => 'COMPILE_WARNING',
            E_USER_ERROR => 'USER_ERROR',
            E_USER_WARNING => 'USER_WARNING',
            E_USER_NOTICE => 'USER_NOTICE',
            E_STRICT => 'STRICT',
            E_RECOVERABLE_ERROR => 'RECOVERABLE_ERROR',
            E_DEPRECATED => 'DEPRECATED',
            E_USER_DEPRECATED => 'USER_DEPRECATED',
            default => 'UNKNOWN'
        };
    }
}
