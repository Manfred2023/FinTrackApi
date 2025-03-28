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
use Dotenv\Dotenv;

class Database
{
    private static $instance = null;

    /**
     * @return void
     */
    public static function connect(): void
    {
        if (self::$instance === null) {
            $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
            $dotenv->load();
            $host = $_ENV['DB_HOST'] . ':' . $_ENV['DB_PORT'];
            $dbname = $_ENV['DB_NAME'];
            $user = $_ENV['DB_USER'];
            $password = $_ENV['DB_PASSWORD'];

            try {
                R::setup("mysql:host=$host;dbname=$dbname", $user, $password);
                R::freeze(true);
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
