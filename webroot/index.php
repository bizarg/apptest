<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));
define('VIEWS_PATH', ROOT.DS.'views');

define('PATH_CSS', $_SERVER['REQUEST_SCHEME'].":".DS.DS.$_SERVER['SERVER_NAME'] . DS . "webroot" . DS . "css" .DS);
define('PATH_JS', $_SERVER['REQUEST_SCHEME'].":".DS.DS.$_SERVER['SERVER_NAME'] . DS . "webroot" . DS . "js" .DS);
define('PATH_IMG', $_SERVER['REQUEST_SCHEME'].":".DS.DS.$_SERVER['SERVER_NAME'] . DS . "webroot" . DS . "img" .DS);
require_once(ROOT.DS.'lib'.DS.'init.php');
define('SITE', 'http:\\' . Config::get('host_name'));

session_start();

App::run($_SERVER['REQUEST_URI']);




