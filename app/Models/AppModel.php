<?php

namespace App\Models;

use Core\Base\Model;

class AppModel extends Model
{
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

    public function uniqueAliasId($id)
    {
        $search = Model::requestArr(
            "$this->table", 'WHERE alias = ? AND id <> ?',
            [$this->attributes['alias'], $id]
        );

        if (!empty($search)) {
            $search = $search[0];
            if ($search['alias'] == $this->attributes['alias']) {
                $this->errors['alias'][] = 'alias не уникальный';
            }
            return false;
        }
        return true;
    }
}