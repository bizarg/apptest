<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));
define('VIEWS_PATH', ROOT.DS.'views');
//define('CSS', dirname(__FILE__).DS.'css'.DS);

require_once(ROOT.DS.'lib'.DS.'init.php');

App::run($_SERVER['REQUEST_URI']);

//$pages = App::$db->query('SELECT * FROM pages');
//
//foreach ($pages->fetchAll(PDO::FETCH_ASSOC) as $row) {
//    echo "<pre>";
//    print_r($row);
//    echo "</pre>";
//}

//$router = new Router($_SERVER['REQUEST_URI']);
//
//echo "<pre>";
//print_r('Route: '.$router->getRoute().PHP_EOL);
//print_r('Language: '.$router->getLanguage().PHP_EOL);
//print_r('Controller: '.$router->getController().PHP_EOL);
//print_r('Action: '.$router->getMethodPrefix().$router->getAction().PHP_EOL);
//echo "Params: ";
//print_r($router->getParams());


