<?php


class Db
{
    private static $user = 'root';
    private static $pass = 'root';
    private static $dsn = "mysql:host=localhost;dbname=socks;charset=utf8";
    private static $opt = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];
    private static $db = null;

    public static function getConnection() {
        if (self::$db === null) {
            try {
                $db = new PDO(self::$dsn, self::$user, self::$pass, self::$opt);
                self::$db = $db;
            }
            catch (PDOException $exception) {
                return $exception->errorInfo;
            }
        }

        return self::$db;
    }

}