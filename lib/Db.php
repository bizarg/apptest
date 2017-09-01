<?php

class DB
{
    private static $connection;

    private function __construct()
    {
    }

    public static function getConnect()
    {
        if(!self::$connection){
            try {
                self::$connection = new PDO('mysql:host='.Config::get('db_host').';dbname='.Config::get('db_name'), Config::get('user'), Config::get('pass'));
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$connection->exec('SET NAMES "utf8"');
            } catch (PDOException $e) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
        }
        return self::$connection;
    }

//    public static function query($sql)
//    {
//
//    }

    private function __clone(){}
}