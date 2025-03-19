<?php
/*
 *  @package BuildTrackApi
 *  @author Manfred MOUKATE
 *  @copyright (c) 2025. All rights reserved.
 *  @license [ Proprietary]
 *  @link fredcode237@gmail.com
 */
require_once __DIR__ . '/../vendor/autoload.php';

use RedBeanPHP\R;

class Database
{
    private static $instance = null;

    /**
     * @return void
     */
    public static function connect(): void
    {
        if (self::$instance === null) {
            $host = 'localhost:3306';
            $dbname = 'nege5774_fintrack';
            $user = 'nege5774_manfred';
            $password = 'Manfred500.';

            try {
                R::setup("mysql:host=$host;dbname=$dbname", $user, $password);
                R::freeze(true); // Empêche la modification automatique des tables
                self::$instance = R::getDatabaseAdapter();
            } catch (Exception $e) {
                die("Erreur de connexion à la base de données : " . $e->getMessage());
            }
        }
    }

    /**
     * @return void
     */
    public static function disconnect(): void
    {
        R::close();
        self::$instance = null;
    }
}
