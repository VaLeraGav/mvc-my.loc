<?php

namespace App\Controllers;

use App\Controllers\AppController;
use App\Models\BreadCrumbs;
use App\Models\CategoryModel;
use Core\Base\Model;

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

        $product = Model::requestObj("SELECT * FROM product WHERE category_id IN ($ids)");

        $this->setMeta($category->title, $category->description, $category->keywords);

        $this->view('pages/category',[
            'products' => $product,
            'breadcrumbs' => $breadcrumbs
        ]);
    }
}