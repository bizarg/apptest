<?php
/**
 * Created by PhpStorm.
 * User: val
 * Date: 05.09.2017
 * Time: 14:32
 */

trait ValidateData
{
    protected $fail = false;
    protected $error = [];

    public function validate($data, $rules, $message = false)
    {
        foreach ($rules as $name => $rule) {
            if ($rule == 'required') {
                if (empty($data[$name]) || !isset($data[$name])) {
                    $this->fail = true;
                    $this->error[] = (isset($message[$name])) ? $message[$name] : "Поле {$name} обязательно к заполнению";
                }
            }
        }
    }
}