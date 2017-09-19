<?php

class Model extends QueryBuilder
{
    protected $fillable = [];
    protected $table;
    protected $db;
    protected $class;
    protected $relations = [];
    protected $destroy = [];
    protected $sql;

    public function __construct()
    {
        $this->db = App::$db;
    }

    public function find($params, $where = 'id', $sign = '=') {
        if($where === 'id') $params = (int)$params;

        $sql = "SELECT * FROM {$this->table} WHERE {$where}{$sign}'{$params}' LIMIT 1";
//        dd($sql);
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

//    public function getWhere($params, $where = 'id', $sign = '=' ) {
//        if($where === 'id') $params = (int)$params;
//
//        $sql = "SELECT * FROM {$this->table} WHERE {$where} {$sign} '{$params}'";
//        $result = $this->db->get($sql);
//
//        if (!isset($result) || !count($result)) return null;
//
//        return $this->collection($result, $this->class);
//    }
//
//    public function getList($only_published = false)
//    {
//        $sql = "SELECT * FROM {$this->table} WHERE 1";
//        if ($only_published) {
//            $sql .= " AND `is_published` = 1";
//        }
//        $result = $this->db->get($sql);
//
//        if (!isset($result) || !count($result)) return null;
//
//        return $this->collection($result, $this->class);
//    }

    public function delete()
    {
        $sql = "DELETE FROM {$this->table} WHERE id={$this->id}";
        return $this->db->input($sql);
    }

    public function destroy()
    {
        if (count($this->destroy)) {

            foreach ($this->destroy as $relate) {
                if (count($this->$relate())) {
                    $this->deleteRelate($this->$relate());
                }
            }
        }

        return $this->delete();
    }

    protected function deleteRelate($value)
    {
        if (is_array($value)) {
            foreach($value as $val) {
                $val->delete();
            }
        } else {
            return $value->delete();
        }

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
        return (new $model())->select()->where($this->id, $key)->get();
    }

    protected function hasOne($model, $key)
    {
        return (new $model())->find($key);
    }

    protected function hasManyToMany($model, $field)
    {
        $relate_table = new $model();

        $list = $relate_table->select()->where($this->id, $field)->get();

        unset($relate_table->relations[$field]);

        $new_class = array_values($relate_table->relations)[0];
        $new_field = array_keys($relate_table->relations)[0];
        $newmodel = new $new_class();

        if (count($list)) {
            $arr = [];

            foreach ($list as $l) {
                $arr[] = $l->$new_field;
            }

//            dd($newmodel->findIn($arr));
            return $newmodel->findIn($arr);
        }

        return null;
    }

    public function findIn(Array $arr) {

        $sql = "SELECT * FROM {$this->table} WHERE id in (".implode(",", $arr).")";

        $result = $this->db->get($sql);

        if (!isset($result) || !count($result)) return null;

        return $this->collection($result, $this->class);
    }

    public function sync($array, $model, $relate, $sign)
    {
//        $data, new BannerImage(),'images', 'banner_id'
        $newmodel = new $model();
        unset($newmodel->relations[$sign]);
        $new_field = array_keys($newmodel->relations)[0];
        $objects = $this->$relate();

        if (count($objects)) {
            foreach ($objects as $object) {
                if(!in_array($object->id, $array)) {
                    $newmodel = new $model();
                    $object_delete = $newmodel->select()->where($object->id, $new_field)->getOne();
//                    dump('delete');
                    $object_delete->delete();
                }
            }
        }

        foreach ($array as $id) {
            $newmodel = new $model();
            $object = $newmodel->select()->where($this->id, $sign)->andWhere($id, $new_field)->getOne();
//            dump($object);

            if (!isset($object->$sign) && !isset($object->$new_field)) {
//                dump('create');
                $newobject = new $model();
                $newobject->$sign = $this->id;
                $newobject->$new_field = $id;
                $newobject->create();
            } elseif (
                isset($object->$sign)
                && $object->$sign == $this->id
                && isset($object->$new_field)
                && $object->$new_field == $id
            ) {
//                dump('continue');
                continue;
            }
            else {
//                dump('update');
                $object->$sign = $this->id;
                $object->$new_field = $id;
                $object->update();
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


    public function get()
    {
        return $this->getCollection($this->db->get($this->sql));
    }

    public function getArray()
    {
         return $this->db->get($this->sql);

    }

    public function getOne()
    {
        return $this->getModel($this->db->get($this->sql));
    }

    public function one($id)
    {
        $id = (int)$id;
        return $this->getModel($this->db->get("SELECT * FROM {$this->table} WHERE id={$id} LIMIT 1 "));
    }

    public function all()
    {
        return $this->getCollection($this->db->get("SELECT * FROM {$this->table}"));
    }



    protected function getModel($array)
    {
        if (count($array)) {
            foreach ($array as $key => $item) {
                foreach ($item as $key => $value) {
                    $this->$key = $value;
                }
            }
            return $this;
        }

        return null;

    }

    protected function getCollection($array)
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