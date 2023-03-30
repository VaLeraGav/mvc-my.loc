<?php

namespace App\Controllers\admin;

use App\Models\CategoryModel;
use Core\App;
use Core\Base\Model;

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
        $children = Model::requestArr("SELECT COUNT(*) FROM `category` WHERE parent_id = $id");
        $countChildren = $children[0]['COUNT(*)'];

        $errors = '';
        if ($countChildren) {
            $errors .= '<li>Удаление невозможно, в категории есть вложенные категории</li>';
        }

        $products = Model::requestArr("SELECT COUNT(*) FROM product WHERE category_id = $id");
        $countProducts = $products[0]['COUNT(*)'];

        if ($countProducts) {
            $errors .= '<li>Удаление невозможно, в категории есть товары</li>';
        }

        if ($errors) {
            $_SESSION['error'] = "<ul>$errors</ul>";
            redirect();
        }

        Model::requestObj(
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
        $category = new CategoryModel();

        $category->load($request);

        $errors = $category->validate($request);
        $boolUnique = $category->uniqueAlias();

//      $alias = $category->str2url($category->attributes['title']);

        if (!empty($errors) || $boolUnique) {
            $errors['alias'] = ($boolUnique) ? ['alias не уникальный'] : '';

            $this->view('admin/category/add', [
                'category' => $category->attributes,
                'errors' => $errors,
            ]);
        } else {
            $_SESSION['success'] = 'Категория добавлена';
            $category->save();
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

        $errors = $cat->validate($request);
        $boolUnique = $cat->uniqueAlias();

        $id = $this->getRequestID(false);
        if (!empty($errors) || $boolUnique) {
            $errors['alias'] = ($boolUnique) ? 'alias не уникальный' : '';
            $_SESSION['val'] = $errors;
            redirect("/admin/category/edit?id=$id");
        } else {
            $cat->updatetGetModel($id);
            $_SESSION['success'] = 'Категория сохранена';
            unset($_SESSION['val']);
            redirect();
        }
    }

}