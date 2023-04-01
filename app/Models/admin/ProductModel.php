<?php

namespace App\Models\admin;

use Core\Base\Model;

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
}