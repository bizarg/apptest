<?php

class Model
{
    protected $fillable = [];
    protected $table;
    protected $db;

    public function __construct()
    {
        $this->db = App::$db;
    }

    public function getById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id='{$id}' LIMIT 1";
        $result = $this->db->query($sql);
        $result = $result->fetchAll(PDO::FETCH_ASSOC);

        return isset($result[0]) ? $result[0] : null;
    }

    public function getList($only_published = false)
    {
        $sql = "SELECT * FROM `pages` WHERE 1";
        if ($only_published) {
            $sql .= " AND `is_published` = 1";
        }
        return $this->db->query($sql);
    }
}