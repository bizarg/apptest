<?php

class Model
{
    protected $fillable = [];
    protected $table;
    protected $db;
    protected $class;
    protected $relations = [];

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

    public function findOrFail($params, $where = 'id', $sign = '=' )
    {
        $result = $this->find($params, $where, $sign);

        if (!$result) {
            throw new Exception('Данного объекта не существует');
        }
        return $result;
    }

    public function getWhere($params, $where = 'id', $sign = '=' ) {
        if($where === 'id') $params = (int)$params;

        $sql = "SELECT * FROM {$this->table} WHERE {$where} {$sign} '{$params}'";
        $result = $this->db->get($sql);

        if (!isset($result) || !count($result)) return null;

        return $this->collection($result, $this->class);
    }

    public function getList($only_published = false)
    {
        $sql = "SELECT * FROM {$this->table} WHERE 1";
        if ($only_published) {
            $sql .= " AND `is_published` = 1";
        }
        $result = $this->db->get($sql);

        if (!isset($result) || !count($result)) return null;

        return $this->collection($result, $this->class);
    }

    public function delete(/*$params, $where = 'id', $sign = '=' */)
    {
        $sql = "DELETE FROM {$this->table} WHERE id={$this->id}";
        return $this->db->input($sql);
//        if($where === 'id') $params = (int)$params;
//
//        $sql = "DELETE FROM {$this->table} WHERE {$where} {$sign} '{$params}'";
//        return $this->db->input($sql);
    }



    public function destroy()
    {
        if (count($this->relations)) {

            foreach ($this->relations as $relate) {
                $this->deleteRelate($this->$relate());
            }
        }
        return $this->delete();
    }

    protected function deleteRelate($value)
    {
        return $value;
        if (is_array($value)) {
            foreach($value as $val) {
                $val->delete();
            }
        }
        return $value->delete();
    }

    public function create()
    {
        $sql = "INSERT INTO {$this->table} SET ";
        foreach ($this->fillable as $field) {
            if (!isset($this->$field)) continue;
            $sql .= "{$field}='{$this->$field}', ";
        }

        $sql = substr($sql, 0, -2);

        $result = $this->db->input($sql);

         if (!$result) return null;

        return $result;
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

    protected function collection($arr, $class)
    {
        $collection = [];
        for ($i = 0; $i < count($arr); $i++) {
            $collection[$i] = new $class();

            foreach ($collection[$i]->fillable as $field) {
                $collection[$i]->$field = $arr[$i][$field];
            }
        }
        return $collection;
    }

    protected function hasMany($model, $key)
    {
        return (new $model())->getWhere($this->id, $key);
    }

    protected function hasOne($model, $key)
    {
        return (new $model())->find($key);
    }

    public function sync($array, $relate, $sign)
    {
        foreach ($array as $id) {
            $objects = $this->$relate();

            foreach ($objects as $object) {
                if(!in_array($object->id, $array)) {
                    $object->$sign = null;
                    $object->update();
                }
            }

            $newObject = new $object->class();
            $newObject = $newObject->find($id);
            $newObject->$sign = $id;
            $newObject->update();
        }
    }
}