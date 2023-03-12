<?php

// Защищенный, просто пусть будет

trait Singleton
{

    public static function getInstance()
    {
        static $instance;

        if (null === $instance) {
            $instance = new self();
        }

        return $instance;
    }

    private function __construct()
    {
        static $hasInstance = false;

        if ($hasInstance) {
            \trigger_error('Class is already instantiated', \E_USER_ERROR);
        }

        $hasInstance = true;
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