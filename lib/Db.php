<?php

class DB
{
    private static $instance;
    private $conn = null;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if(!self::$instance){
           self::$instance = new self();
        }
        return self::$instance;
    }

    private function initConnect()
    {
        $this->conn = new PDO('mysql:host='.Config::get('db_host').';dbname='.Config::get('db_name'), Config::get('user'), Config::get('pass'));
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->conn->exec('SET NAMES "utf8"');
    }

    public function get($sql)
    {
        if($this->conn === null) $this->initConnect();

        $result = $this->conn->query($sql);
        $array = $result->fetchAll(PDO::FETCH_ASSOC);

        if (count($array) > 1) {
            $collection = [];
            foreach ($array as $key => $item) {
                foreach ($item as $key => $value) {
                    $this->$key = $value;
                }
                $collection[] = $this;
            }
            dd($collection);
            return $collection;
        } else {
            foreach ($array as $key => $item) {
                foreach ($item as $key => $value) {
                    $this->$key = $value;
                }
            }
            dd($this);
            return $this;
        }
    }

    public function input($sql)
    {
        if($this->conn === null) $this->initConnect();
        $result = $this->conn->query($sql);
        if (!$result) return false;

        $id = $this->conn->lastInsertId();

        if ($id == 0) return true;

        return $id;
    }

    private function __clone(){}
}