<?php

class Model
{
    protected $fillable = [];
    protected $table;
    protected $db;
    protected $class;

    public function __construct()
    {
        $this->db = App::$db;
    }

    public function find($params, $where = 'id', $sign = '=' ) {
        if($where === 'id') $params = (int)$params;

        $sql = "SELECT * FROM {$this->table} WHERE {$where}{$sign}'{$params}' LIMIT 1";
        $result = $this->db->get($sql);

        if (!isset($result) || !count($result)) return null;

        foreach ($this->fillable as $field) {
            $this->$field = $result[0][$field];
        }
        return $this;
    }

    public function getWhere($params, $where = 'id', $sign = '=' ) {
        if($where === 'id') $params = (int)$params;

        $sql = "SELECT * FROM {$this->table} WHERE {$where} {$sign} '{$params}'";
        $result = $this->db->get($sql);

        return isset($result) ? $result : null;
    }

    public function getList($only_published = false)
    {
        $sql = "SELECT * FROM {$this->table} WHERE 1";
        if ($only_published) {
            $sql .= " AND `is_published` = 1";
        }
        $result = $this->db->get($sql);

        if (!isset($result) || !count($result)) return null;

        $collection = [];

        for ($i = 0; $i < count($result); $i++) {
            $collection[$i] = new $this->class();

            foreach ($collection[$i]->fillable as $field) {
                $collection[$i]->$field = $result[$i][$field];
            }
        }

        return $collection;
    }

    public function delete($params, $where = 'id', $sign = '=' )
    {
        if($where === 'id') $params = (int)$params;

        $sql = "DELETE FROM {$this->table} WHERE {$where} {$sign} '{$params}'";
        return $this->db->input($sql);
    }

    public function create()
    {
        $sql = "INSERT INTO {$this->table} SET ";
        foreach ($this->fillable as $field) {
            if (!isset($this->$field)) continue;
            $sql .= "{$field}='{$this->$field}', ";
        }

        $sql = substr($sql, 0, -2);

         if (!$this->db->input($sql)) return null;

        return true;
    }

//    public function update($data, $params, $where = 'id', $sign = '=')
//    {
//        if ($where == 'id') $params = (int)$params;
//
//        if (in_array('is_published', $this->fillable)) {
//            $data['is_published'] = isset($data['is_published']) ? 1 : 0;
//        }
//
//        $sql = "UPDATE {$this->table} SET ";
//        foreach ($this->fillable as $field) {
//            if(!isset($data[$field])) continue;
//            $sql .= "{$field}='{$data[$field]}', ";
//        }
//        $sql = substr($sql, 0, -2);
//        $sql .= " WHERE {$where}{$sign}{$params}";
//
//        return $this->db->input($sql);
//    }

    public function update()
    {
        $sql = "UPDATE {$this->table} SET ";
        foreach ($this->fillable as $field) {
            $sql .= "{$field}='{$this->$field}', ";
        }
        $sql = substr($sql, 0, -2);
        $sql .= " WHERE id={$this->id}";

        return $this->db->input($sql);
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }
}