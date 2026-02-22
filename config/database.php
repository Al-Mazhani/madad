<?php
define('DBHOST', 'localhost');
define('DBNAME', 'madadOne');
define('DBUSER', 'root');
define('DBPASS', '');
class Database
{
    private static $pdo = null;

    public static function Connection()
    {
        if (self::$pdo === null) {

            try {
                $connection = "mysql:host=" . DBHOST . ";dbname=" . DBNAME . ";charset=utf8";
                self::$pdo = new PDO($connection, DBUSER, DBPASS);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("فشل الاتصال بقاعدة البيانات: " . $e->getMessage());
            }
        }

        return self::$pdo;
    }
}
