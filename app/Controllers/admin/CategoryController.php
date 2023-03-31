<?php

namespace App\Controllers\admin;

use App\Models\CategoryModel;
use Core\App;
use Core\Base\Model;
use Core\Logger;

class CategoryController extends AppController
{
    public function index()
    {
        $this->setMeta('Список категорий');
        $this->view('admin/category/index');
    }

    public function delete()
    {
        $id = $this->getRequestID();

        $countChildren = Model::count('category', 'parent_id = ?', [$id]);

        $errors = '';
        if ($countChildren) {
            $errors .= "<li>Удаление невозможно, в категории есть вложенные категории: $countChildren</li>";
        }

        $countProducts = Model::count('product', 'category_id = ?', [$id]);

        if ($countProducts) {
            $errors .= "<li>Удаление невозможно, в категории есть товары: $countProducts</li>";
        }

        if ($errors) {
            $_SESSION['error'] = "<ul>$errors</ul>";
            redirect();
        }

        Model::queryNew(
            " DELETE FROM `category` WHERE `category`.id = $id"
        );

        $_SESSION['success'] = 'Категория удалена';
        redirect();
    }

    public function add()
    {
        $this->setMeta('Добавить категорию');
        $this->view('admin/category/add');
    }

    public function store($request)
    {
        $this->setMeta('Добавить категорию');
        $cat = new CategoryModel();

        $cat->load($request);

        $cat->hasErrors($request);
        $cat->uniqueAlias();

        if (!empty($cat->errors)) {
            $this->view('admin/category/add', [
                'category' => $cat->attributes,
                'errors' => $cat->errors,
            ]);
        } else {
            $_SESSION['success'] = 'Категория добавлена';
            $cat->save();
            redirect();
        }
    }

    public function edit()
    {
        $this->setMeta('Редактирование категории');

        $id = $this->getRequestID();

        $cat = new CategoryModel();
        $category = $cat->find('id', $id);

        App::$app->setProperty('parent_id', $category['parent_id']);

        $this->view('admin/category/edit', [
            'category' => $category,
        ]);
    }

    public function update($request)
    {
        $this->setMeta('Редактирование категории');

        $cat = new CategoryModel();
        $cat->load($request);
        $id = $this->getRequestID(false);

        $cat->hasErrors($request);
        $cat->uniqueAliasId($id);

        if (!empty($cat->errors)) {
            $_SESSION['val'] = $cat->errors;
            redirect("/admin/category/edit?id=$id");
        } else {
            $cat->updatetGetModel($id);

            $_SESSION['success'] = 'Категория сохранена';
            unset($_SESSION['val']);
            redirect();
        }
    }

}