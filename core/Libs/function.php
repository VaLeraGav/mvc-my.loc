<?php

function dpre($value, $die = false): void
{
    echo '<pre>';
    print_r($value);
    echo '</pre>';
    if ($die) {
        die;
    }
}

function redirect($http = false, $statusCode = 302)
{
    if ($http) {
        $redirect = $http;
    } else {
        $redirect = $_SERVER['HTTP_REFERER'] ?? '/'; // на ту же самую
    }
    header('Location: ' . $redirect, true, $statusCode);
    exit;
}

function h($str): string
{
    return htmlspecialchars($str, ENT_QUOTES);
}


function makeObj($arrays)
{
    $var = [];
    foreach ($arrays as $k => $v) {
        $var[$k] = (object)$v;
    }
    return $var;
}