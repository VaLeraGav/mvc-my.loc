<?php

namespace Core;

class Cache
{
    public function __construct()
    {
    }

    public static function set($key, $data, $second = 3600)
    {
        if ($second)  // для тестирования
        {
            $content['date'] = $data;
            $content['end_time'] = time() + $second;

            $pathDir = CACHE . '/';
            if (!is_dir($pathDir)) {
                @mkdir($pathDir, 0777, true);
            }
            if (file_put_contents(CACHE . '/' . md5($key) . '.txt', serialize($content))) {
                return '';
            }
        }
        return false;
    }

    public static function get($key)
    {
        $file = CACHE . '/' . md5($key) . '.txt';
        if (file_exists($file)) {
            $content = unserialize(file_get_contents($file));

            if (time() <= $content['end_time']) {
                return $content['date'];
            }
            unlink($file);
        }
        return false;
    }

    public static function delete($key)
    {
        $file = CACHE . '/' . md5($key) . '.txt';
        if (file_exists($file)) {
            unlink($file);
        }
        return false;
    }


    /**
     * Буферизирует
     *
     *  if (\Core\CacheMy::begin('testdiv')) {
     *      echo '<div>какоц то массив1</div>';
     *      echo '<div>какоц то массив1</div>';
     *      \Core\CacheMy::end('testdiv', 10);
     *  } else {
     *      \Core\CacheMy::get('testdiv');
     *  }
     */
    public static function begin($key)
    {
        if ($content = self::get($key)) {
            echo $content;
            return false;
        } else {
            ob_start();
            return true;
        }
    }

    public static function end($key, $second = 3600)
    {
        echo self::set($key, ob_get_clean(), $second);
    }

}

