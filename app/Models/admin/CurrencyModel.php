<?php

namespace App\Models\admin;

use App\Models\AppModel;

class CurrencyModel extends AppModel
{
    public string $table = 'currency';

    public array $attributes = [
        'title' => '',
        'code' => '',
        'symbol_left' => '',
        'symbol_right' => '',
        'value' => '',
        'base' => '',
    ];

    public array $rules = [
        'title' => 'require',
        'code' => 'require',
        'value' => 'require|numeric',
    ];
}
