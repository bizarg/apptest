<?php

require_once(ROOT . DS . 'config' . DS . 'config.php');

function __autoload($class_name) {
    $lib_path = ROOT . DS . 'lib' . DS . $class_name . '.php';
    $controller_path = ROOT . DS . 'controllers' . DS . $class_name . '.php';
    $model_path = ROOT . DS . 'models' . DS . $class_name . '.php';



    if (file_exists($lib_path)) {
        require_once($lib_path);
    } elseif (file_exists($controller_path)) {
        require_once($controller_path);
    } elseif (file_exists($model_path)) {
        require_once($model_path);
    } else {
        throw new Exception('Failed to include clss: '.$class_name);
    }
}

function __($key, $default_value = '') {
    return Lang::get($key, $default_value);
}

function dd($value) {
    var_dump($value);die;
}