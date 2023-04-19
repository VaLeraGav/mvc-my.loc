<?php

namespace App\Controllers\admin;

use App\Models\admin\CurrencyModel;
use Core\Base\Model;

class CurrencyController extends AppController
{
    public function index()
    {
        $this->setMeta('Управление валютами');

        $currencies = Model::requestArr('currency');

        $this->view('admin/currency/index', [
            'currencies' => $currencies,
        ]);
    }

    public function add()
    {
        $this->setMeta('Добавление валюты');

        $this->view('admin/currency/add');
    }

    public function store($request)
    {
        $currency = new CurrencyModel();

        $currency->load($request);
        $currency->attributes['base'] = $currency->attributes['base'] ? '1' : '0';
        $currency->hasErrors($request);

        if (!empty($currency->errors)) {
            $_SESSION['val'] = $currency->errors;
            $this->view('admin/currency/add', [
                'currency' => $currency->attributes,
            ]);
        } else {
            $currency->save();
            $_SESSION['success'] = 'Группа добавлена';
            redirect();
        }
    }

    public function edit()
    {
        $this->setMeta('Управление валютами');

        $id = $this->getRequestID();
        $curr = Model::queryNew("SELECT * FROM currency WHERE id = ?", [$id])[0];

        $this->view('admin/currency/edit', [
            'currency' => $curr,
        ]);
    }

    public function update($request)
    {
        $currency = new CurrencyModel();
        $currency->load($request);
        $currency->attributes['base'] = $currency->attributes['base'] ? '1' : '0';
        $currency->hasErrors($request);
        $id = $this->getRequestID(false);

        if (!empty($currency->errors)) {
            $_SESSION['val'] = $currency->errors;
        } else {
            $currency->updatetGetModel($id);
            $_SESSION['success'] = 'Валюта изменена';
        }
        redirect();
    }

    public function delete()
    {
        $id = $this->getRequestID();
        Model::queryNew("DELETE FROM currency WHERE id = ?", [$id]);
        $_SESSION['success'] = 'Валюта удалена';
        redirect();
    }
}