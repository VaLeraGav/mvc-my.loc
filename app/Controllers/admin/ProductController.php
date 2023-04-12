<?php

namespace App\Controllers\admin;

use App\Models\admin\ProductModel;
use Core\Base\Model;
use Core\Libs\Pagination;
use Core\Logger;

class ProductController extends AppController
{
    public function index()
    {
        $this->setMeta('Список товаров');

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perpage = 10;
        $count = Model::count('product');
        $pagination = new Pagination($page, $perpage, $count);
        $start = $pagination->getStart();

        $products = Model::queryNew(
            "SELECT product.*, category.title AS cat 
                    FROM product 
                        JOIN category ON category.id = product.category_id 
                    ORDER BY product.title 
                    LIMIT $start, $perpage"
        );

        $this->view('admin/product/index', [
            'products' => $products,
            'pagination' => $pagination,
            'count' => $count
        ]);
    }

    public function add()
    {
        $this->setMeta('Новый товар');

        $this->view('admin/product/add');
    }

    public function store($request)
    {
        $this->setMeta('Новый товар');

        $product = new ProductModel();

        $product->load($request);
        $product->hasErrors($request);
        $product->uniqueAlias();

//        dpre($request);

        if (!empty($product->errors)) {
            $this->view('admin/product/add', [
                'product' => $product->attributes,
                'errors' => $product->errors,
            ]);
        } else {
            $product->attributes['status'] = $product->attributes['status'] ? '1' : '0';
            $product->attributes['hit'] = $product->attributes['hit'] ? '1' : '0';
            $product->attributes['old_price'] = $product->attributes['old_price'] ?: '0';

            $_SESSION['success'] = 'Товар добавлен';

            $id = $product->save(['attrs']);
            $product->editFilter($id, $request['attrs']);

            redirect();
        }
    }
}