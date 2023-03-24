<?php

namespace App\Models;

use Core\App;
use Core\Base\Model;

class CategoryModel extends Model
{
    public function getIds($id)
    {
        $cats = App::$app->getProperty('cats');
        $ids = null;
        foreach($cats as $k => $v) {
            if($v['parent_id'] == $id) {
                $ids .= $k . ', ';
                $ids .= $this->getIds($k);
            }
        }
        return $ids;
    }
}