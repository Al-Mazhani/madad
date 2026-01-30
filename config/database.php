<?php
define('DBHOST', 'localhost');
define('DBNAME', 'madad');
define('DBUSER', 'root');
define('DBPASS', '');

class database
{

   public  static function Connection()
    {
        try {
            $connection = "mysql:host=" . DBHOST . ";dbname=" . DBNAME . ";charset=utf8";
            $pdo = new PDO($connection, DBUSER, DBPASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die("فشل الاتصال بقاعدة البيانات: " . $e->getMessage());
        }
    }
}
