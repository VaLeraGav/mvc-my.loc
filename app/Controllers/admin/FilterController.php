<?php

namespace App\Controllers\admin;

use App\Models\admin\FilterAttrModel;
use App\Models\admin\FilterGroupModel;
use App\Models\OrderModel;
use Core\Base\Model;
use Core\Libs\Pagination;
use Core\Logger;

class FilterController extends AppController
{

    // -------------------------attribute-----------------------------

    public function attribute(): void
    {
        $this->setMeta('Фильтры');

        $attrs = Model::queryNew(
            "SELECT attribute_value.*, attribute_group.title FROM attribute_value 
                                    JOIN attribute_group ON attribute_group.id = attribute_value.attr_group_id"
        );

        $this->view('admin/filter/attribute', [
            'attrs' => $attrs,
        ]);
    }

    public function attributeGroup(): void
    {
        $this->setMeta('Группы фильтров');

        $attrs_group = Model::requestArr('attribute_group');

        $this->view('admin/filter/attribute_group', [
            'attrs_group' => $attrs_group,
        ]);
    }

    public function attributeAdd()
    {
        $this->setMeta('Новая группа фильтров');

        $group = Model::requestArr('attribute_group');

        $this->view('admin/filter/attribute_add', [
            'group' => $group
        ]);
    }

    public function attributeStore($request)
    {
        $attribute = new FilterAttrModel();
        $attribute->load($request);
        $attribute->hasErrors($request);

        if (!empty($attribute->errors)) {
            $_SESSION['val'] = $attribute->errors;
        } else {
            $attribute->save();
            $_SESSION['success'] = 'Группа добавлена';
        }
        redirect();
    }

    public function attributeEdit()
    {
        $this->setMeta('Новая группа фильтров');

        $id = $this->getRequestID();
        $attr = Model::queryNew("SELECT * FROM attribute_value WHERE id = ?", [$id])[0];
        $attrs_group = Model::requestArr('attribute_group');

        $this->view('admin/filter/attribute_edit', [
            'attr' => $attr,
            'attrs_group' => $attrs_group
        ]);
    }

    public function attributeUpdate($request)
    {
        $attribute = new FilterAttrModel();
        $attribute->load($request);
        $attribute->hasErrors($request);
        $id = $this->getRequestID(false);

        if (!empty($attribute->errors)) {
            $_SESSION['val'] = $attribute->errors;
        } else {
            $attribute->updatetGetModel($id);
            $_SESSION['success'] = 'Группа изменена';
        }
        redirect();
    }

    public function attributeDelete()
    {
        $id = $this->getRequestID();
        Model::queryNew("DELETE FROM attribute_value WHERE id = ?", [$id]);
        $_SESSION['success'] = 'Фильтр удален';
        redirect();
    }

    // -------------------------group-----------------------------
    public function groupAdd()
    {
        $this->setMeta('Новый фильтр');

        $this->view('admin/filter/group_add');
    }

    public function groupStore($request)
    {
        $group = new FilterGroupModel();
        $group->load($request);
        $group->hasErrors($request);

        if (!empty($group->errors)) {
            $this->view('admin/filter/group_add', [
                'errors' => $group->errors
            ]);
        } else {
            $group->save();
            $_SESSION['success'] = 'Группа добавлена';
            redirect();
        }
    }

    public function groupEdit()
    {
        $this->setMeta('Редактирование группы фильтров');

        $id = $this->getRequestID();
        $group = Model::queryNew("SELECT * FROM attribute_group WHERE id = ?", [$id])[0];

        $this->view('admin/filter/group_edit', [
            'group' => $group
        ]);
    }

    public function groupUpdate($request)
    {
        $group = new FilterGroupModel();
        $group->load($request);
        $group->hasErrors($request);

        $id = $this->getRequestID(false);

        if (!empty($group->errors)) {
            $_SESSION['val'] = $group->errors;
            redirect();
        } else {
            $group->updatetGetModel($id);
            $_SESSION['success'] = 'Группа изменена';
        }
        redirect();
    }


    public function groupDelete(): void
    {
        $id = $this->getRequestID();
        $count = Model::count('attribute_value', 'attr_group_id = ?', [$id]);

        if ($count) {
            $_SESSION['error'] = 'Удаление невозможно, в группе есть аттрибуты';
            redirect();
        }

        Model::queryNew('DELETE FROM attribute_group WHERE id = ?', [$id]);
        $_SESSION['success'] = 'Удалено';
        redirect();
    }

}