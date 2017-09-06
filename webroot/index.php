<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));
define('VIEWS_PATH', ROOT.DS.'views');

require_once(ROOT.DS.'lib'.DS.'init.php');

define('SITE', 'http://' . Config::get('host_name'));

session_start();

App::run($_SERVER['REQUEST_URI']);




