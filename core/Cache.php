<?php

namespace Core;

use Core\Libs\TSingletone;

class Cache
{
    use TSingletone;

    public function set($key, $data, $second = 3600)
    {
        if ($second)  // для тестирования
        {
            $content['data'] = $data;
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

    public function get($key)
    {
        $file = CACHE . '/' . md5($key) . '.txt';
        if (file_exists($file)) {
            $content = unserialize(file_get_contents($file));

            if (time() <= $content['end_time']) {
                return $content['data'];
            }
            unlink($file);
        }
        return false;
    }

    public function delete($key)
    {
        $file = CACHE . '/' . md5($key) . '.txt';
        if (file_exists($file)) {
            unlink($file);
        }
    }


    /**
     * Буферизирует вывод
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
        $content = self::instance()->get($key);
        if ($content) {
            echo $content;
            return false;
        } else {
            ob_start();
            return true;
        }
    }

    public static function end($key, $second = 3600)
    {
        echo self::instance()->set($key, ob_get_clean(), $second);
    }

}

