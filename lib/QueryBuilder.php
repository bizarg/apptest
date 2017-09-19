<?php

class QueryBuilder
{
    public function orderBy($column, $sort = 'ASC')
    {
        $this->sql .= " ORDER BY {$column} {$sort} ";
        return $this;
    }

    public function groupBy($column)
    {
        $this->sql .= " GROUP BY {$column} ";
        return $this;
    }

    public function having($column, $params, $sign = '=')
    {
        $this->sql .= " HAVING {$column}{$sign}'{$params}' ";
        return $this;
    }

    public function innerJoin($table)
    {
        $this->sql .= "SELECT * FROM {$this->table} INNER JOIN {$table} ON {$this->table}.id={$table}.id ";
        return $this;
    }

    public function addJoin($table, $field1, $field2)
    {
        $this->sql .= " INNER JOIN $table ON {$field1}={$field2} ";
        return $this;
    }

    public function andWhere($params, $where = 'id', $sign = '=')
    {
        if ($where == 'id') $params = (int)$params;
        $this->sql .= " AND {$where}{$sign}'{$params}' ";
        return $this;
    }

    public function orWhere($params, $where = 'id', $sign = '=')
    {
        if ($where == 'id') $params = (int)$params;
        $this->sql .= " OR {$where}{$sign}'{$params}' ";
        return $this;
    }

    public function where($params, $where = 'id', $sign = '=')
    {
        if ($where == 'id') $params = (int)$params;
        $this->sql .= " WHERE {$where}{$sign}'{$params}' ";
        return $this;
    }

    public function whereIn(Array $arr, $where)
    {
        $this->sql .= " WHERE {$where} in (".implode(",", $arr).") ";
        return $this;
    }

    public function select($column = '*')
    {
        $this->sql .= "SELECT " . $column . " FROM {$this->table} ";
        return $this;
    }
}