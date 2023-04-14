<?php

namespace App\Models\admin;

use App\Models\AppModel;

class FilterAttrModel extends AppModel
{
    public string $table = 'attribute_value';

    public array $attributes = [
        'value' => '',
        'attr_group_id' => '',
    ];

    public array $rules = [
        'value' => 'require',
        'attr_group_id' => 'require|integer'
    ];
}
