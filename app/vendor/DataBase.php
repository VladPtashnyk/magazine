<?php 
    class DataBase
    {
        private static $connection;

        public static function connection()
        {
            if (empty(self::$connection)) {
                $host = 'localhost'; 
                $dbname = 'magazine_db'; 
                $user = 'root'; 
                $password = ''; 
                $charset = 'utf8';
    
                $dsn = 'mysql:host'.$host.';dbname'. $dbname.';charter'.$charset;
                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ];
                self::$connection = new PDO($dsn, $user, $password, $options);
            }

            return self::$connection;
        }
    }