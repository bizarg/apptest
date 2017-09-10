<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));
define('VIEWS_PATH', ROOT.DS.'views');

require_once(ROOT.DS.'lib'.DS.'init.php');

define('PATH_CSS', $_SERVER['REQUEST_SCHEME'].":".DS.DS.$_SERVER['SERVER_NAME'] . DS . "webroot" . DS . "css" .DS);
define('PATH_JS', $_SERVER['REQUEST_SCHEME'].":".DS.DS.$_SERVER['SERVER_NAME'] . DS . "webroot" . DS . "js" .DS);
define('PATH_IMG', $_SERVER['REQUEST_SCHEME'].":".DS.DS.$_SERVER['SERVER_NAME'] . DS . "webroot" . DS . "img" .DS);

session_start();
//dd($_SERVER);
App::run($_SERVER['REQUEST_URI']);




