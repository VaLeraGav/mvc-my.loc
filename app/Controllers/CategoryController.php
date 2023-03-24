<?php

namespace App\Controllers;

use App\Controllers\AppController;
use App\Models\BreadCrumbs;
use App\Models\CategoryModel;
use Core\App;
use Core\Base\Model;
use Core\Libs\Pagination;

class CategoryController extends AppController
{

    public function index($alias)
    {
        $category = Model::requestObj("SELECT * FROM category WHERE alias = '{$alias}'");

        if (!$category) {
            throw new \Exception('Страница не найдена', 404);
        }

        $category = $category[0];
        $breadcrumbs = BreadCrumbs::getBreadCrumbs($category->id);

        $cat_model = new CategoryModel();

        $ids = $cat_model->getIds($category->id);
        $ids = !$ids ? $category->id : $ids . $category->id;

        //pagination
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perpage = App::$app->getProperty('pagination');

        $total = Model::requestArr("SELECT * FROM product WHERE category_id IN ($ids)");

        $pagination = new Pagination($page, $perpage, count($total));
        $start = $pagination->getStart();

        $products = Model::requestObj("SELECT * FROM product WHERE category_id IN ($ids) LIMIT $start, $perpage");
        $this->setMeta($category->title, $category->description, $category->keywords);

        $this->view('pages/category', [
            'products' => $products,
            'breadcrumbs' => $breadcrumbs,
            'pagination' => $pagination,
        ]);
    }
}