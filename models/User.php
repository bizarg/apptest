<?php

class User extends Model
{
    public function getByLogin($login)
    {
        $sql = "SELECT * FROM users WHERE login = '{$login}' LIMIT 1";
        $result = $this->db->query($sql);
        $result = $result->fetchAll(PDO::FETCH_ASSOC);
        if (isset($result)) {
            return$result[0];
        }
        return false;
    }
}