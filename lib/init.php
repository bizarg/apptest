<?php

require_once(ROOT . DS . 'config' . DS . 'config.php');

//spl_autoload_register("__autoload");

function __autoload($class_name) {

    $paths = [
        ROOT . DS . 'lib' . DS,
        ROOT . DS . 'controllers' . DS,
        ROOT . DS . 'models' . DS
    ];

    $controllers = new DirectoryIterator(ROOT . DS . 'controllers');

    foreach ($controllers as $dir) {
        if ($dir == '.' || $dir == '..') continue;

        if ($dir->isDir()) {
            $paths[] = ROOT . DS . 'controllers' . DS . $dir->getBasename() . DS;
        }
    }

    foreach ($paths as $path) {
        $class = $path . $class_name . '.php';
        if (file_exists($class)) {
            require_once($class);
            break;
        }
    }

    if (!file_exists($class)) {
        throw new Exception('Failed to include clss: '.$class_name);
    }
}



function __($key, $default_value = '') {
    return Lang::get($key, $default_value);
}

function dd($value = null) {
    var_dump($value);die;
}
function dump($value) {
    var_dump($value);
}

function view($value, $data = null){
    if ($data) extract($data);

    include path($value,VIEWS_PATH).".php";
}

function path($value, $include = SITE) {
    $path = explode('.', $value);

    for ($i = 0; $i < count($path); $i++) {
        $include .= DS.$path[$i];
    }
    return $include;
}

function checkArr($var){
    if(count($var) && isset($var)) return $var;

    return $var = [];
}