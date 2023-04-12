<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Новый товар
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= ADMIN ?>"><i class="fa fa-dashboard"></i>Главная</a></li>
        <li class="breadcrumb-item"><a href="<?= ADMIN ?>/category">Список товатор</a></li>
        <li class="breadcrumb-item active">Новый товар</li>
    </ol>
</section>

<div class="row">
    <div class="col-md-12">
        <?php if(isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>
        <?php if(isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php //if(!empty($errors)): ?>
<!--    <div class="text-danger">--><?php //dpre($errors) ?><!--</div>-->
<?php //endif; ?>

<!-- Main content -->
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <form action="<?= ADMIN; ?>/product/add" method="post" novalidate>

                        <div class="form-group">
                            <label for="title">Наименование товара</label>
                            <?php if(!empty($errors['title'])): ?>
                                <div class="text-danger"><?php print_r(array_shift($errors['title'])) ?></div>
                            <?php endif; ?>
                            <input type="text" name="title" class="form-control" id="title"
                                   placeholder="Наименование товара" value="<?= $product['title'] ?? '' ?>">
                        </div>

                        <div class="form-group">
                            <label for="title">Alias</label>
                            <?php if(!empty($errors['alias'])): ?>
                                <div class="text-danger"><?php print_r(array_shift($errors['alias'])) ?></div>
                            <?php endif; ?>
                            <input type="text" name="alias" class="form-control" id="title"
                                   placeholder="alias для поиска" value="<?= $product['alias'] ?? '' ?>">
                        </div>

                        <div class="form-group">
                            <label for="category_id">Родительская категория</label>
                            <?php if(!empty($errors['category_id'])): ?>
                                <div class="text-danger"><?php print_r(array_shift($errors['category_id'])) ?></div>
                            <?php endif; ?>
                            <?php new \App\Widgets\Menu\Menu([
                                'tpl' => WWW . '/menu/select.php',
                                'container' => 'select',
                                'cache' => 0,
                                'cackeKey' => 'admin_select',
                                'attrs' => [
                                    'name' => 'category_id',
                                    'id' => 'category_id'
                                ],
                                'class' => 'form-control',
                                'prepend' => '<option value>Выберите категорию</option>',
                            ]);?>
                        </div>

                        <div class="form-group">
                            <label for="brand_id">ID бренда</label>
                            <input type="text" name="brand_id" class="form-control" id="brand_id"
                                   placeholder="ID бренда" value="<?= $product['brand_id'] ?? '' ?>">
                        </div>

                        <div class="form-group">
                            <label for="keywords">Ключевые слова</label>
                            <input type="text" name="keywords" class="form-control" id="keywords"
                                   placeholder="Ключевые слова" value="<?= $product['keywords'] ?? '' ?>">
                        </div>

                        <div class="form-group">
                            <label for="description">Описание товара</label>
                            <input type="text" name="description" class="form-control" id="description"
                                   placeholder="Описание товара" value="<?= $product['description'] ?? '' ?>">
                        </div>

                        <div class="form-group">
                            <label for="price">Цена</label>
                            <?php if(!empty($errors['price'])): ?>
                                <div class="text-danger"><?php print_r(array_shift($errors['price'])) ?></div>
                            <?php endif; ?>
                            <input type="text" name="price" class="form-control" id="price"
                                   placeholder="Цена" value="<?= $product['price'] ?? '' ?>">
                        </div>

                        <div class="form-group">
                            <label for="old_price">Старая цена</label>
                            <?php if(!empty($errors['old_price'])): ?>
                                <div class="text-danger"><?php print_r(array_shift($errors['old_price'])) ?></div>
                            <?php endif; ?>
                            <input type="text" name="old_price" class="form-control" id="old_price"
                                   placeholder="Старая цена" value="<?= $product['old_price'] ?? '' ?>">
                        </div>

                        <div class="form-group">
                            <label for="content">Контент</label>
                                <textarea name="content" id="editor1" cols="180" rows="10"
                                          value="<?= $product['content'] ?? '' ?>">
                                </textarea>
                        </div>

                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="status" checked> Статус
                            </label>
                        </div>

                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="hit"> Хит
                            </label>
                        </div>

                        <div class="form-group">
                            <label for="related">Связанные товары</label>
                            <select name="related[]" class="form-control select2 select2-blue" id="related" multiple></select>
                        </div>

                        <?php new  \App\Widgets\Filter\Filter(null, WWW . '/filter/admin_filter_tpl.php');?>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-success">Добавить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->
