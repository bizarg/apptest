<?php

class Model
{
    protected $fillable = [];
    protected $table;
    protected $db;
    protected $class;
    protected $relations = [];
    protected $sql;

    public function __construct()
    {
        $this->db = App::$db;
    }

    public function find($params, $where = 'id', $sign = '=') {
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

    public function delete()
    {
        $sql = "DELETE FROM {$this->table} WHERE id={$this->id}";
        return $this->db->input($sql);
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

        return $this->db->input($sql);
    }

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

    protected function hasManyToMany($model, $field)
    {
        $relate_table = new $model();

        $list = $relate_table->getWhere($this->id, $field);

        unset($relate_table->relations[$field]);

        $new_class = array_values($relate_table->relations)[0];
        $new_field = array_keys($relate_table->relations)[0];
        $newmodel = new $new_class();

        if (count($list)) {
            $arr = [];

            foreach ($list as $l) {
                $arr[] = $l->$new_field;
            }

            $str = implode(',', $arr);

            $images = $newmodel->findIn($str);

            return $images;
        }

        return null;
    }

    public function findIn($str) {

        $sql = "SELECT * FROM {$this->table} WHERE id in ({$str})";
        $result = $this->db->get($sql);

        if (!isset($result) || !count($result)) return null;

        return $this->collection($result, $this->class);
    }

    protected function hasOne($model, $key)
    {
        return (new $model())->find($key);
    }

    public function sync($array, $model, $relate, $sign)
    {
        $this->$relate();

        $newmodel = new $model();
        unset($newmodel->relations[$sign]);
        $new_field = array_keys($newmodel->relations)[0];

        if (count($this->$relate)) {
            foreach ($this->$relate as $object) {
                $newmodel = new $model();
                if(!in_array($object->id, $array)) {
                    $banner_image = $newmodel->find($object->id, $new_field);
                    $banner_image->delete();
                }
            }
        }

        foreach ($array as $id) {
            $newmodel = new $model();

            $banner_image = $newmodel->find($id, $sign);


            if (!$banner_image) {
                $newmodel = new $model();
                $newmodel->$sign = $this->id;
                $newmodel->$new_field = $id;
                $newmodel->create();
            } else {
                if ($banner_image->$sign == $this->id && $banner_image->$new_field == $id) {

                } else {
                    $newmodel = new $model();
                    $newmodel->$sign = $this->id;
                    $newmodel->$new_field = $id;
                    $newmodel->create();
                }
            }
        }
    }

    public function getKey($array)
    {
        $key = [];
        foreach (checkArr($array) as $item) {
            $key[] = $item->id;
        }

        return $key;
    }
//    --------------------------------------------------------------
    public function andWhere($params, $where = 'id', $sign = '=')
    {
        $this->sql .= " AND {$where}{$sign}'{$params}' ";
        return $this;
    }

    public function orWhere($params, $where = 'id', $sign = '=')
    {
        $this->sql .= " OR {$where}{$sign}'{$params}' ";
        return $this;
    }

    public function where($params, $where = 'id', $sign = '=')
    {
        $this->sql .= " WHERE {$where}{$sign}'{$params}' ";
        return $this;
    }

    public function whereIn($str, $where)
    {
        $this->sql .= " WHERE {$where} in ('$str') ";
        return $this;
    }

    public function select($column = '*')
    {
        $this->sql .= "SELECT " . $column . " FROM {$this->table} ";
        return $this;
    }

    public function get()
    {
        return $this->getCollection($this->db->get($this->sql));
    }

    public function getOne()
    {
        return $this->getModel($this->db->get($this->sql));
    }

    public function one($id)
    {
        return $this->getModel($this->db->get("SELECT * FROM {$this->table} WHERE id={$id} LIMIT 1 "));
    }

    public function all()
    {
        return $this->getCollection($this->db->get("SELECT * FROM {$this->table}"));
    }

    public function orderBy($column, $sort = 'DESC')
    {
        $this->sql .= " ORDER BY {$column} {$sort} ";
    }

    public function groupBy($column)
    {
        $this->sql .= " GROUP BY {$column} ";
    }

    public function having($column, $params, $sign = '=')
    {
        $this->sql .= " HAVING {$column}{$sign}'{$params}' ";
    }

    public function innerJoin($table)
    {
        $this->sql .= "SELECT * FROM {$this->table} INNER JOIN {$table} ON {$this->table}.id={$table}.id ";
    }

    public function addJoin($table1, $table2)
    {
        $this->sql .= " INNER JOIN $table1 ON {$table1}.id={$table2}.id ";
    }

    public function getModel($array)
    {
        foreach ($array as $key => $item) {
            foreach ($item as $key => $value) {
                $this->$key = $value;
            }
        }
        return $this;
    }

    public function getCollection($array)
    {
        $collection = [];
        for ($i = 0; $i < count($array); $i++) {
            $collection[$i] = new $this->class();

            foreach ($collection[$i]->fillable as $field) {
                $collection[$i]->$field = $array[$i][$field];
            }
        }
        return $collection;
    }


}