<?php

namespace App\Models\admin;

use Core\Base\Model;
use Core\Logger;

class ProductModel extends Model
{
    public string $table = 'product';

    public array $attributes = [
        'title' => '',
        'category_id' => '',
        'brand_id' => '',
        'keywords' => '',
        'description' => '',
        'price' => '',
        'old_price' => '',
        'content' => '',
        'status' => '',
        'hit' => '',
        'alias' => '',
    ];

    public array $rules = [
        'title' => 'require',
        'category_id' => 'require',
        'brand_id' => 'require|integer',
        'price' => 'require|numeric',
        'old_price' => 'numeric',
        'alias' => 'require',
    ];

    public function uniqueAlias()
    {
        $sql = "SELECT * FROM {$this->table} WHERE alias = :value";
        $search = $this->query($sql, [':value' => $this->attributes['alias']])->fetch();

        if (!empty($search)) {
            $this->errors['alias'][] = 'alias не уникальный';
            return false;
        }
        return true;
    }

    public function editFilter($id, $data)
    {
        $filter = Model::queryNew('SELECT attr_id FROM attribute_product WHERE product_id = ?', [$id]);

        // если менеджер убрал фильтры - удаляем их (только с чекбоксами, с радиокнопками не работает)
        if (empty($data['attrs']) && !empty($filter)) {
            Model::queryNew("DELETE FROM attribute_product WHERE product_id = ?", [$id]);
            return;
        }

        // если фильтры добавляются
        if (empty($filter) && !empty($data['attrs'])) {
            $sql_part = $this->getSqlFilter($data['attrs'], $id);
            Model::queryNew("INSERT INTO attribute_product (attr_id, product_id) VALUES $sql_part");
            return;
        }

        //если изменились фильтры - удалим и запишем новые
        if (!empty($data['attrs'])) {
            $result = array_diff($filter, $data['attrs']);
            if (!$result || count($result) != count($data['attrs'])) {
                Model::queryNew("DELETE FROM attribute_product WHERE product_id = ?", [$id]);

                $sql_part = $this->getSqlFilter($data['attrs'], $id);
                Model::queryNew("INSERT INTO attribute_product (attr_id, product_id) VALUES $sql_part");
            }
        }
    }

    public function getSqlFilter($attr, $id): string
    {
        $sql_part = '';
        foreach ($attr as $v) {
            $sql_part .= "($v, $id),";
        }
        return rtrim($sql_part, ',');
    }

    public function editRelatedFilter($id, $data)
    {
        $relatedProduct = Model::queryNew('SELECT related_id FROM related_product WHERE product_id = ?', [$id]);

        // если менеджер убрал фильтры - удаляем их (только с чекбоксами, с радиокнопками не работает)
        if (empty($data['related']) && !empty($relatedProduct)) {
            Model::queryNew("DELETE FROM related_product WHERE product_id = ?", [$id]);
            return;
        }

        // если связанные товары добавляются
        if (empty($relatedProduct) && !empty($data['related'])) {
            $sql_part = $this->getSqlFilter($data['related'], $id);
            Model::queryNew("INSERT INTO related_product (related_id, product_id) VALUES $sql_part");
            return;
        }

        //если изменились связанные товары - удалим и запишем новые
        if (!empty($data['related'])) {
            $result = array_diff($relatedProduct, $data['related']);

            if (!empty($result) || count($relatedProduct) != count($data['related'])) {
                Model::queryNew("DELETE FROM related_product WHERE product_id = ?", [$id]);
                $sql_part = $this->getSqlFilter($data['related'], $id);
                Model::queryNew("INSERT INTO related_product (related_id, product_id) VALUES $sql_part");
            }
        }
    }
}