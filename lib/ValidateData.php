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
            $arr_rules = explode('|', $rule);

            foreach ($arr_rules as $item) {

                if ($item == "email") {

                    if(!filter_var($data[$name], FILTER_VALIDATE_EMAIL)) {
                        $this->error[$name] = (isset($message[$name])) ? $message[$name] : "Поле {$name} не валидный";
                    }

                }

                if (strstr($item, 'min')){
                    if (!empty($data[$name])) {
                        $int = explode(':', $item);
                        if ($int[0] == 'min') {
//                        dd($int[1]);
                            if ($int[1] > strlen($data[$name])) {
                                $this->error[$name] = (isset($message[$name])) ? $message[$name] : "Поле {$name} должна быть не менее {$int[1]} символов";
                            }
                        }
                    }
                }

                if (strstr($item, 'max')){
                    if (!empty($data[$name])) {
                        $int = explode(':', $item);

                        if ($int[0] == 'max') {
                            if ($int[1] < strlen($data[$name])) {
                                $this->error[$name] = (isset($message[$name])) ? $message[$name] : "Поле {$name} должна быть не более {$int[1]} символов";
                            }
                        }
                    }
                }

                if ($item == "password") {

                    if (6 <= strlen($data[$name]) && 32 >= strlen($data[$name])) {

//                        (?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$
                        if(!preg_match('/[0-9a-zA-Z!@#$%^&*]{6,}/', $data[$name])) {
                            $this->error[$name] = (isset($message[$name])) ? $message[$name] : "Поле {$name} содержит не доступные символы (доступные символы !@#$%^&*)";
                        }

                    } else {
                        $this->error[$name] = (isset($message[$name])) ? $message[$name] : "Поле {$name} должен быть не менее 6-ти символов и не более 32-ух символов";
                    }
                }


                if ($item == 'required') {
                    if (empty($data[$name]) || !isset($data[$name])) {
                        $this->error[$name] = (isset($message[$name])) ? $message[$name] : "Поле {$name} обязательно к заполнению";
                    }
                }
                if($item == 'int') {
                    if (!empty($data[$name])) {
                        if (!preg_match('/^[0-9]{1,}$/', $data[$name])) {
                            $this->error[$name] = (isset($message[$name])) ? $message[$name] : "В поле {$name} должно быть только числовое значение";
                        }
                    }
                }

            }
        }
        if (count($this->error)) $this->fail = true;
    }
}