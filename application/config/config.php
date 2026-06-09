<?php
/********************************************************/
/**	config.php est inclus sur toutes les pages du site **/
/********************************************************/
session_start();
//Pour afficher les jours et mois en français
setlocale(LC_TIME, 'fr-FR.UTF8', 'fra');
//Pour l'heure locale
date_default_timezone_set('Europe/Paris');

/********************************************************/
/** Chargement des variables d'environnement (.env)    **/
/********************************************************/
require_once __DIR__ . "/../../framework/EnvLoader.class.php";
EnvLoader::load(__DIR__ . "/../../.env");

/********************************************************/
/** Les constantes (depuis les variables .env)         **/
/********************************************************/
define("SITE_NOM", EnvLoader::get("SITE_NOM", "nom du site"));
define("APP_ENV", EnvLoader::get("APP_ENV", "development"));
define("DB_SERVER", EnvLoader::get("DB_SERVER", "localhost"));
define("DB_PORT", EnvLoader::get("DB_PORT", "3306"));
define("DB_USER", EnvLoader::get("DB_USER", "root"));
define("DB_PWD", EnvLoader::get("DB_PWD", ""));
define("DB_BDD", EnvLoader::get("DB_BDD", "base de données"));

/********************************************************/
/** chargement des classes de base du framework        **/
/********************************************************/
//fonctions utiles
require "../framework/fonction.php";
//Logger pour les erreurs
require "../framework/Logger.class.php";
//Gestionnaire d'erreurs
require "../framework/ErrorHandler.class.php";
//classe mère des objets table de la base de données
require "../framework/Table.class.php";
//interface pour l'implémentation des actiosn du CRUD
require "../framework/I_crud.class.php";
//class mère des controleurs secondaires attachés à chaque table
require "../framework/Ctr_controleur.class.php";
//protection CSRF
require "../framework/CsrfToken.class.php";
//auto chargement des classes (monAutoload est définie dans _lib/fonction.php)
spl_autoload_register('monAutoLoad');

/********************************************************/
/** Initialisation du système de gestion d'erreurs     **/
/********************************************************/
Logger::init(__DIR__ . "/../../logs");
ErrorHandler::register();

/********************************************************/
/** connexion à la base de données                     **/
/********************************************************/

try {
    Table::$link = new PDO("mysql:host=" . DB_SERVER . ";port=" . DB_PORT . ";dbname=" . DB_BDD, DB_USER, DB_PWD);
} catch (Exception $e) {
    Table::$link = new PDO("mysql:host=" . DB_SERVER . ";port=" . DB_PORT, DB_USER, DB_PWD);
}

Table::$link->exec("SET NAMES UTF8");
//Définit le mode de la méthode fetch par défaut
Table::$link->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
//déclenche une exception en cas d'erreur : stop l'éxécution
Table::$link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
