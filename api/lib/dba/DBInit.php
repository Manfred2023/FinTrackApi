<?php
/*
 *  BuildTrackApi
 *
 *  Created by Manfred MOUKATE on 1/7/25, 10:15 AM,
 *  Email moukatemanfred@gmail.com
 *  Copyright (c) 2025. All rights reserved.
 *  Last modified 1/7/25, 10:15 AM
 */

class DBInit
{
    /**
     * List of table creation SQL statements
     */
    private static $tables = [
        'user' => "
        CREATE TABLE IF NOT EXISTS user (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nickname VARCHAR(100) NOT NULL UNIQUE, 
            email VARCHAR(255) NOT NULL, 
            mobile VARCHAR(255) NOT NULL UNIQUE, 
            pin VARCHAR(100) NOT NULL, 
            admin BOOLEAN DEFAULT FALSE,
            blocked BOOLEAN DEFAULT FALSE,
            created TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
        ); 
    ",
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

