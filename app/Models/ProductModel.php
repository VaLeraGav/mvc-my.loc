<?php

namespace App\Models;

use Core\Base\Model;

class ProductModel extends Model
{

    public string $table = 'product';

    public function getProduct($alias)
    {
        $productFind = $this->requestObj("SELECT * FROM {$this->table} WHERE alias = '{$alias}' AND status = '1'");
        if (!$productFind) {
            throw new \Exception('Станица не найдена', 404);
        }
        return array_shift($productFind);
    }

    public function relatedProducts($id)
    {
        return $this->requestArr(
            "SELECT * FROM related_product JOIN {$this->table} ON product.id = related_product.related_id WHERE related_product.product_id = {$id}"
        );
    }

    public function getGallery($id)
    {
        return $this->requestObj("SELECT * FROM gallery WHERE product_id = {$id}");
    }

    // добавляет просмотренный товар
    public function setRecentlyViewed($id)
    {
        $recentlyViewed = $this->getAllRecentlyViewed();
        if (!$recentlyViewed) {
            setcookie('recentlyViewed', $id, time() + 3600 * 24, '/');
        } else {
            $recentlyViewed = explode('.', $recentlyViewed);
            if (!in_array($id, $recentlyViewed)) {
                $recentlyViewed[] = $id;
                $recentlyViewed = implode('.', $recentlyViewed);
                setcookie('recentlyViewed', $recentlyViewed, time() + 3600 * 24, '/');
            }
        }
    }

    public function getRecentlyViewed()
    {
        if (!empty($_COOKIE['recentlyViewed'])) {
            $recentlyViewed = $_COOKIE['recentlyViewed'];
            $recentlyViewed = explode('.', $recentlyViewed);
            return array_slice($recentlyViewed, -4);
        }
        return false;
    }

    // получить все просмотренные товары
    public function getAllRecentlyViewed()
    {
        if (!empty($_COOKIE['recentlyViewed'])) {
            return $_COOKIE['recentlyViewed'];
        }
        return false;
    }

}