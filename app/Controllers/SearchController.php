<?php

namespace App\Controllers;

use Core\App;
use Core\Base\Model;
use Core\Libs\Pagination;
use Core\Logger;

class SearchController extends AppController
{

    public function typeahead()
    {
        if ($this->isAjax()) {
            $query = !empty(trim($_GET['query'])) ? trim($_GET['query']) : null;
        }

        if ($query) {
            $products = Model::queryNew(
                "SELECT id, title FROM product WHERE title like \"%$query%\" AND status = '1' LIMIT 11"
            );

            echo json_encode($products);
        }
        die;
    }

    public function index()
    {
        $query = !empty(trim($_GET['s'])) ? trim($_GET['s']) : null;
        $this->setMeta('Поиск по: ' . h($query));

        if ($query) {
            $total = Model::requestObj('product', "WHERE title LIKE  ? AND status = '1'", ["%{$query}%"]);
        }

        //pagination
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perpage = App::$app->getProperty('pagination');

        $pagination = new Pagination($page, $perpage, count($total));
        $start = $pagination->getStart();

        $products = Model::requestObj(
            'product', "WHERE title LIKE ? AND status = '1' LIMIT ?, ?", ["%{$query}%", $start, $perpage]
        );

        $this->view('pages/search', [
            'products' => $products,
            'query' => $query,
            'pagination' => $pagination,
        ]);
    }
}