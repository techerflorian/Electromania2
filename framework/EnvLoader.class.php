<?php

/**
 * Classe pour charger les variables d'environnement depuis un fichier .env
 */
class EnvLoader
{
    /**
     * Charge le fichier .env et définit les variables d'environnement
     *
     * @param string $filePath Chemin vers le fichier .env
     * @return void
     */
    public static function load(string $filePath): void
    {
        if (!file_exists($filePath)) {
            throw new Exception("Le fichier .env n'existe pas : $filePath");
        }

        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        foreach ($lines as $line) {
            // Ignorer les commentaires
            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            // Parser les lignes KEY=VALUE
            if (strpos($line, '=') !== false) {
                [$key, $value] = explode('=', $line, 2);
                $key = trim($key);
                $value = trim($value);
                
                // Retirer les guillemets si présents
                if ((strpos($value, '"') === 0 && strrpos($value, '"') === strlen($value) - 1) ||
                    (strpos($value, "'") === 0 && strrpos($value, "'") === strlen($value) - 1)) {
                    $value = substr($value, 1, -1);
                }
                
                // Définir la variable d'environnement
                putenv("$key=$value");
                $_ENV[$key] = $value;
            }
        }
    }

    /**
     * Récupère une variable d'environnement
     *
     * @param string $key      Clé de la variable
     * @param mixed  $default  Valeur par défaut
     * @return mixed
     */
    public static function get(string $key, $default = null)
    {
        return $_ENV[$key] ?? getenv($key) ?: $default;
    }
}
