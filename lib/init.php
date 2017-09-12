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

    ob_start();
    include path($value,VIEWS_PATH).".php";
    $content = ob_get_clean();
    return $content;
}

function path($value, $include = SITE) {
    $path = explode('.', $value);

    for ($i = 0; $i < count($path); $i++) {
        $include .= DS.$path[$i];
    }
    return $include;
}

function checkArr($var){
    if(isset($var) && count($var)) return $var;

    return [];
}

function resize($filename, $uploadfile, $type, $max_resolution = 250){
    // файл

//    $filename = $dir.$file;

// задание максимальной ширины и высоты
//    $width = 200;
//    $height = 200;

// тип содержимого
//    header('Content-Type: image/jpeg');

// получение новых размеров
//    list($width_orig, $height_orig) = getimagesize($filename);
////
//    $ratio_orig = $width_orig/$height_orig;
//
//    if ($width/$height > $ratio_orig) {
//        $width = $height*$ratio_orig;
//    } else {
//        $height = $width/$ratio_orig;
//    }
    $createfrom = 'imagecreatefrom'.$type;
    $image = 'image'.$type;

    $original_image = $createfrom($filename);

    $original_width = imagesx($original_image);
    $original_height = imagesy($original_image);

    $ratio = $max_resolution/$original_width;
    $new_width = $max_resolution;
    $new_height = $original_height*$ratio;

    if($new_height<$max_resolution){
        $ratio = $max_resolution/$original_height;
        $new_height = $max_resolution;
        $new_width = $original_width * $ratio;
    }

    if ($original_image) {
        $new_image = imagecreatetruecolor($new_width, $new_height);
        imagecopyresampled($new_image, $original_image, 0, 0, 0, 0, $new_width, $new_height, $original_width, $original_height);
        $image($new_image, $uploadfile, 90);

        imagedestroy($original_image);
        imagedestroy($new_image);
        return true;
    }
//// ресэмплирование
//    $image_p = imagecreatetruecolor($width, $height);
//    $image = imagecreatefromjpeg($filename);
//    imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
//
//// вывод

}

