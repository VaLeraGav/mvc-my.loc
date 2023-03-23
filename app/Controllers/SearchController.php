<?php


namespace App\Controllers;


use Core\Base\Model;
use Core\Logger;

class SearchController extends AppController
{

    public function typeahead()
    {
        if ($this->isAjax()) {
            $query = !empty(trim($_GET['query'])) ? trim($_GET['query']) : null;
        }

        if ($query) {
            $products = Model::requestArr(
                "SELECT id, title FROM product WHERE title like \"%$query%\" AND status = '1' LIMIT 11"
            );
            echo json_encode($products);
        }
        die;
    }

    public function index()
    {
        $query = !empty(trim($_GET['s'])) ? trim($_GET['s']) : null;
        if($query) {
            $products = Model::requestObj("SELECT * FROM product WHERE title LIKE  \"%$query%\" AND status = '1'");
        }
        $this->setMeta('Поиск по: ' . h($query));
        $this->view('pages/search', [
            'products' => $products,
            'query' => $query
        ]);
    }
}