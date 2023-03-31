<?php

namespace App\Controllers;

use App\Controllers\AppController;
use App\Models\BreadCrumbs;
use App\Models\CategoryModel;
use App\Widgets\Filter\Filter;
use Core\App;
use Core\Base\Model;
use Core\Libs\Pagination;

class CategoryController extends AppController
{

    public function index($alias)
    {
        $category = Model::requestObj('category', 'WHERE alias = ?', [$alias]);

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


        $sql_part = '';
        if (!empty($_GET['filter'])) {
            $filter = Filter::getFilter();
            if ($filter) {
                // или
                // $sql_part = "AND id IN (SELECT product_id FROM attribute_product WHERE attr_id IN ($filter))";

                //  SELECT * FROM product WHERE category_id IN(6) and id IN
                //  (
                //      SELECT product_id FROM attribute_product WHERE attr_id IN(1, 5)
                //  ) LIMIT 0, 4;

                // и
                $cnt = Filter::getCountGroups($filter);
                $sql_part = "AND id IN (SELECT product_id FROM attribute_product WHERE attr_id IN ($filter) 
                            GROUP BY product_id HAVING COUNT(product_id) = $cnt)";
            }
        }

        $total = Model::requestArr('product', "WHERE category_id IN (?) $sql_part", [$ids]);

        $pagination = new Pagination($page, $perpage, count($total));
        $start = $pagination->getStart();

        $products = Model::requestObj(
            'product', "WHERE status = '1' AND category_id IN ($ids) $sql_part LIMIT ?, ?", [$start, $perpage]
        );

        $this->setMeta($category->title, $category->description, $category->keywords);

        if ($this->isAjax()) {
            $this->loadView('category/filter', [
                'products' => $products,
                'pagination' => $pagination,
            ]);
        }

        $this->view('category/category', [
            'products' => $products,
            'breadcrumbs' => $breadcrumbs,
            'pagination' => $pagination,
        ]);
    }
}