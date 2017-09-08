<?php

class Session
{
    protected static $flash_message;


    public static function setUri($uri)
    {
        $_SESSION['uri'][] = $uri;
    }

    public static function getUri()
    {
        return $_SESSION['uri'][count($_SESSION['uri'])-3];
    }

    public static function setFlash($message)
    {
        self::$flash_message = $message;
    }

    public static function hasFlash()
    {
        return !is_null(self::$flash_message);
    }

    public static function flash()
    {
        return self::$flash_message;
//        self::$flash_message = null;
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function setFail($key, $value)
    {
        self::$fail[$key] = $value;
    }

    public static function getFail($key)
    {
        echo self::$fail[$key];
    }

    public static function get($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
    }

    public static function has($key)
    {
        if (isset($_SESSION[$key])) {
            return true;
        }
        return false;
    }

    public static function delete($key)
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
        return null;
    }

    public static function destroy()
    {
        session_destroy();
    }



}