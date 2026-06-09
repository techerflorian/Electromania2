<?php

/**
 * Classe de gestion des tokens CSRF (Cross-Site Request Forgery)
 * 
 * Utilisation :
 * - À l'affichage d'un formulaire : CsrfToken::generate()
 * - À la soumission : CsrfToken::verify($_POST['csrf_token'])
 */
class CsrfToken
{
    const TOKEN_NAME = 'csrf_token';
    const TOKEN_LENGTH = 32;

    /**
     * Génère un nouveau token CSRF et le stocke en session
     *
     * @return string Le token généré
     */
    public static function generate(): string
    {
        // Générer un nouveau token à chaque fois (plus sûr)
        $token = bin2hex(random_bytes(self::TOKEN_LENGTH));
        $_SESSION[self::TOKEN_NAME] = $token;
        return $token;
    }

    /**
     * Retourne le token actuel sans le régénérer
     *
     * @return string|null Le token ou null si absent
     */
    public static function get(): ?string
    {
        return $_SESSION[self::TOKEN_NAME] ?? null;
    }

    /**
     * Vérifie qu'un token CSRF est valide
     *
     * @param string $token Le token à vérifier
     * @return bool True si valide, False sinon
     */
    public static function verify(string $token): bool
    {
        if (empty($token) || empty($_SESSION[self::TOKEN_NAME])) {
            return false;
        }

        // Utiliser hash_equals() pour éviter les attaques par timing
        return hash_equals($_SESSION[self::TOKEN_NAME], $token);
    }

    /**
     * Génère le champ HTML caché pour un formulaire
     * À utiliser dans les vues
     *
     * @return string Le HTML du champ caché
     */
    public static function field(): string
    {
        $token = self::generate();
        return '<input type="hidden" name="' . self::TOKEN_NAME . '" value="' . htmlspecialchars($token) . '">';
    }

    /**
     * Renouvelle le token (à faire après une action sensible)
     * Ex: après connexion/déconnexion
     *
     * @return string Le nouveau token
     */
    public static function regenerate(): string
    {
        unset($_SESSION[self::TOKEN_NAME]);
        return self::generate();
    }
}
