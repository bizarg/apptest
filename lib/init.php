<?php

require_once(ROOT . DS . 'config' . DS . 'config.php');

function __autoload($class_name) {

    $lib_path = ROOT . DS . 'lib' . DS . $class_name . '.php';
    $controller_path = ROOT . DS . 'controllers' . DS . $class_name . '.php';
    $model_path = ROOT . DS . 'models' . DS . $class_name . '.php';

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



//    if (file_exists($lib_path)) {
//        require_once($lib_path);
//    } elseif (file_exists($controller_path)) {
//        require_once($controller_path);
//    } elseif (file_exists($model_path)) {
//        require_once($model_path);
//    } else {
//        throw new Exception('Failed to include clss: '.$class_name);
//    }
}

function __($key, $default_value = '') {
    return Lang::get($key, $default_value);
}

function dd($value) {
    var_dump($value);die;
}
function dump($value) {
    var_dump($value);
}