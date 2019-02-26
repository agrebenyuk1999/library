<?php
class Session
{
    public function __construct()
    {
        session_start();
    }
    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }
    public function unset($key)
    {
        unset($_SESSION[$key]);
    }
    public function destroy()
    {
        session_destroy();
    }
    public function isNotEmptySession($key)
    {
        if (!empty($_SESSION[$key])) {
            return $_SESSION[$key];
        }else return '';
    }
}
