<?php

namespace Core\Libs;

trait TSingletone
{
    private static $instance;

    public static function instance()
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    private function __clone()
    {
        \trigger_error('Class could not be cloned', \E_USER_ERROR);
    }

    private function __wakeup()
    {
        \trigger_error('Class could not be deserialized', \E_USER_ERROR);
    }
}