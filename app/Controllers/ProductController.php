<?php

namespace App\Controllers;

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

        // просмотренный товар

        // галерея
        $gallery = Model::requestObj("SELECT * FROM gallery WHERE product_id = {$product->id}");
dpre($gallery);
        // модификация


        $this->setMeta($product->title, $product->description, $product->keywords);
        $this->view('pages/product', [
            'product' => $product,
            'related' => $related,
            'gallery' => $gallery
        ]);
    }
}