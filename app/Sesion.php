<?php

class Sesion
{

    public function __construct()
    {
        session_start();
    }

    public function setSesion($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    public function closeSesion()
    {
        session_unset();
        session_destroy();
    }
}
