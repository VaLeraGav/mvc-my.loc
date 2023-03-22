<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\UserModel;
use Core\Base\Model;

class ProductController extends AppController
{
    public function index($alias): void
    {
        // опасно так вставлять
        $product = Model::requestObj("SELECT * FROM product WHERE alias = '{$alias}' AND status = '1'");
        if (!$product) {
            throw new \Exception('Станица не найдена', 404);
        }
        $product = array_shift($product);

        // хлебные крошки

        // связанные товары
        $related = Model::requestArr(
            "SELECT * FROM related_product JOIN product ON product.id = related_product.related_id WHERE related_product.product_id = {$product->id}"
        );

        // запись в куки запрошенного товара
        $p_model = new ProductModel();
        $p_model->setRecentlyViewed($product->id);

        // просмотренный товар
        $r_viewed = $p_model->getRecentlyViewed();
        $recentlyViewed = null;
        if ($r_viewed) {
            $slot = implode(', ', $r_viewed);
            $recentlyViewed = Model::requestArr("SELECT * FROM product  WHERE id IN ({$slot}) LIMIT 3");
        }

        // галерея
        $gallery = Model::requestObj("SELECT * FROM gallery WHERE product_id = {$product->id}");

        // модификация

        $this->setMeta($product->title, $product->description, $product->keywords);
        $this->view('pages/product', [
            'product' => $product,
            'related' => $related,
            'gallery' => $gallery,
            'recentlyViewed' => $recentlyViewed
        ]);
    }
}