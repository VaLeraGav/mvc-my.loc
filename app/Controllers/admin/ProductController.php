<?php

namespace App\Controllers\admin;

use App\Models\admin\ProductModel;
use Core\App;
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
            'count' => $count,
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
        $product->getImg();

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

            $id = $product->save(['attrs', 'related']);

            $product->editFilter($id, $request);
            $product->editRelatedFilter($id, $request);
            $product->saveGallery($id);

            redirect();
        }
    }

    public function related()
    {
        $q = $_GET['q'] ?? '';
        $data['items'] = [];

        $products = Model::queryNew('SELECT id, title FROM product WHERE title LIKE ? LIMIT 10', ["%{$q}%"]);

        if ($products) {
            $i = 0;
            foreach ($products as $product) {
                $data['items'][$i]['id'] = $product['id'];
                $data['items'][$i]['text'] = $product['title'];
                $i++;
            }
        }

        echo json_encode($data);
    }

    public function addImage()
    {
        if (isset($_GET['upload'])) {
            if ($_POST['name'] == 'single') {
                $wmax = App::$app->getProperty('img_width');
                $hmax = App::$app->getProperty('img_height');
            } else {
                $wmax = App::$app->getProperty('gallery_width');
                $hmax = App::$app->getProperty('gallery_height');
            }
            $name = $_POST['name'];
            $product = new ProductModel();

            $product->uploadImg($name, $wmax, $hmax);
        }
    }

    public function edit()
    {
        $id = $this->getRequestID();

        $prod = new ProductModel();
        $product = $prod->find('id', $id);

        App::$app->setProperty('parent_id', $product['category_id']);

        $filter = Model::queryNew("SELECT attr_id FROM `attribute_product` WHERE product_id = ?", [$id]);

        $related_product = Model::queryNew(
            "SELECT related_product.related_id, product.title FROM related_product 
                            JOIN product ON product.id = related_product.related_id 
                            WHERE related_product.product_id = ?", [$id]
        );
        $gallery = Model::queryNew('SELECT img FROM gallery WHERE product_id = ?', [$id]);

        $this->setMeta("Редактирование товара {$product['title']}");
        $this->view('admin/product/edit', [
            'product' => $product,
            'filter' => array_column($filter, 'attr_id'),
            'related_product' => $related_product,
            'gallery' => $gallery
        ]);
    }

    public function update($request)
    {
        $this->setMeta('Редактирование товара');

        $id = $this->getRequestID(false);

        $product = new ProductModel();
        $product->load($request, ['related', 'attrs']);
        $product->getImg();

        $product->hasErrors($request);
        $product->uniqueAliasId($id);

        if (!empty($product->errors)) {
            $_SESSION['val'] = $product->errors;
            redirect("/admin/product/edit?id=$id");
        } else {
            $product->attributes['status'] = $product->attributes['status'] ? '1' : '0';
            $product->attributes['hit'] = $product->attributes['hit'] ? '1' : '0';
            $product->attributes['old_price'] = $product->attributes['old_price'] ?: '0';

            $product->editFilter($id, $request);
            $product->editRelatedFilter($id, $request);
            $product->saveGallery($id);

            $_SESSION['success'] = 'Товар успешно изменен';
            $product->updatetGetModel($id);

            redirect();
        }
    }

    public function deleteGallery($request)
    {
        $id = $request['id'] ?? null;
        $src = $request['src'] ?? null;

        if (!$id || !$src) {
            return;
        }
        if (Model::queryNew("DELETE FROM gallery WHERE product_id = ? AND img = ?", [$id, $src])) {
            unlink(WWW . "/images/$src");
            exit('1');
        }
    }

}