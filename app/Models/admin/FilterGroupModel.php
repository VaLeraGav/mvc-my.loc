<?php

namespace App\Models\admin;

use App\Models\AppModel;

class FilterGroupModel extends AppModel
{
    public string $table = 'attribute_group';

    public array $attributes = [
        'title' => '',
    ];

    public array $rules = [
        'title' => 'require',
    ];
}
