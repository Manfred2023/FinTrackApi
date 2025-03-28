<?php
/*
 *  @package BuildTrackApi
 *  @author Manfred MOUKATE
 *  @copyright (c) 2025. All rights reserved.
 *  @license [Proprietary]
 *  @link fredcode237@gmail.com
 */

require_once __DIR__ . '/../vendor/autoload.php';

use RedBeanPHP\R;
class DBInit
{
    /**
     * List of table creation SQL statements
     */
    private static $tables = [
        'user' => "
        CREATE TABLE IF NOT EXISTS user (
            id INT AUTO_INCREMENT PRIMARY KEY,
            token VARCHAR(100) NOT NULL UNIQUE, 
            nickname VARCHAR(100) NOT NULL , 
            email VARCHAR(255) NOT NULL UNIQUE, 
            mobile VARCHAR(255) NOT NULL UNIQUE, 
            pin VARCHAR(100) NOT NULL, 
            admin BOOLEAN DEFAULT FALSE,
            blocked BOOLEAN DEFAULT FALSE,
            created TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
        ); 
    ",
        'account' => "
        CREATE TABLE IF NOT EXISTS account (
            id INT AUTO_INCREMENT PRIMARY KEY,
            token VARCHAR(100) NOT NULL UNIQUE, 
            amount FLOAT NOT NULL,
            user INT NOT NULL, 
            FOREIGN KEY (user) REFERENCES user(id) ON DELETE CASCADE,
            created TIMESTAMP DEFAULT CURRENT_TIMESTAMP  
        );
    ",
        'motif' => "
        CREATE TABLE IF NOT EXISTS motif (
            id INT AUTO_INCREMENT PRIMARY KEY,
            token INT NOT NULL UNIQUE, 
            name VARCHAR(100) NOT NULL UNIQUE, 
            type ENUM('spend', 'income') NOT NULL, 
            account INT NOT NULL, 
            FOREIGN KEY (account) REFERENCES account(id) ON DELETE CASCADE,
            created TIMESTAMP DEFAULT CURRENT_TIMESTAMP  
        );

    ",
        'contact' => "
        CREATE TABLE IF NOT EXISTS contact (
            id INT AUTO_INCREMENT PRIMARY KEY,
            token INT NOT NULL UNIQUE, 
            name VARCHAR(100) NOT NULL  , 
            mobile VARCHAR(255) NOT NULL UNIQUE, 
            location VARCHAR(100),  
            account INT NOT NULL, 
            FOREIGN KEY (account) REFERENCES account(id) ON DELETE CASCADE,
            created TIMESTAMP DEFAULT CURRENT_TIMESTAMP  
        );

    ",
        'status' => "
        CREATE TABLE IF NOT EXISTS status (
            id INT AUTO_INCREMENT PRIMARY KEY,
            token INT NOT NULL UNIQUE, 
            name VARCHAR(100) NOT NULL  , 
            isdone BOOLEAN DEFAULT FALSE, 
            created TIMESTAMP DEFAULT CURRENT_TIMESTAMP  
        );

    ",
        'loan' => "
        CREATE TABLE IF NOT EXISTS loan (
            id INT AUTO_INCREMENT PRIMARY KEY,
            token INT NOT NULL UNIQUE, 
            amount INT NOT NULL, 
            isdone BOOLEAN DEFAULT FALSE, 
            isloan BOOLEAN DEFAULT FALSE, 
            contact INT NOT NULL, 
            updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (contact) REFERENCES contact(id) ON DELETE CASCADE 
        );

    "


    ];


    /**
     * Initialize tables
     */
    public static function initialize(): void
    {
        foreach (self::$tables as $table => $sql) {
            try {
                R::exec($sql);

            } catch (Exception $e) {
                echo "Error creating table '$table': " . $e->getMessage() . "\n";
            }
        }
    }

    /**
     * @return string[]
     */
    public static function getTables(): array
    {
        return self::$tables;
    }

    /**
     * @param string[] $tables
     */
    public static function setTables(array $tables): void
    {
        self::$tables = $tables;
    }
}