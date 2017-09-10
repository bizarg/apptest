<?php

class App
{
    protected static $router;

    public static $db;

    public static $uri;

    /**
     * @return mixed
     */
    public static function getRouter()
    {
        return self::$router;
    }

    public static function run($uri)
    {
        self::$router = new Router($uri);

        self::$db = DB::getInstance();

        self::$uri = self::$router->getUri();

        Lang::load(self::$router->getLanguage());

        $controller_class = self::$router->getController() . 'Controller';
        $controller_method = self::$router->getAction();

        if(self::$router->getRoute() == 'admin') $controller_class = 'Admin'.$controller_class;



        $layout = self::$router->getRoute();

        if ($layout == 'admin' && Session::get('role') != 'admin') {
            if ($controller_method != 'login') {
                Router::redirect('/auth/login');
            }
        }

        $controller_object = new $controller_class();

        if (method_exists($controller_object, $controller_method)) {
            $result = call_user_func_array([$controller_object, $controller_method], App::$router->getParams());

            if ($result != null) {
                throw new Exception('Method '. $controller_method. ' of class '.$controller_class. ' does not work.');
            }

        } else {
            throw new Exception('Method '. $controller_method. ' of class '.$controller_class. ' does not exist.');
        }

    }
}