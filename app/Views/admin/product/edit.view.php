<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Редактирование товара <?= $product['title'];?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= ADMIN ?>"><i class="fa fa-dashboard"></i>Главная</a></li>
        <li class="breadcrumb-item"><a href="<?= ADMIN ?>/product">Список товатор</a></li>
        <li class="breadcrumb-item active">Редактирование товара</li>
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

<!-- Main content -->
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <form action="<?= ADMIN; ?>/product/edit" method="post" novalidate>

                        <div class="form-group">
                            <label for="title">Наименование товара</label>
                            <?php if(!empty($_SESSION['val']['title'])): ?>
                                <div class="text-danger"><?php print_r(array_shift($_SESSION['val']['title'])); unset($_SESSION['val']['title'])?></div>
                            <?php endif; ?>
                            <input type="text" name="title" class="form-control" id="title"
                                   placeholder="Наименование товара" value="<?= h($product['title']) ?>">
                        </div>

                        <div class="form-group">
                            <label for="title">Alias</label>
                            <?php if(!empty($_SESSION['val']['alias'])): ?>
                                <div class="text-danger"><?php print_r(array_shift($_SESSION['val']['alias'])); unset($_SESSION['val']['alias'])?></div>
                            <?php endif; ?>
                            <input type="text" name="alias" class="form-control" id="title"
                                   placeholder="alias для поиска" value="<?= $product['alias'] ?? '' ?>">
                        </div>

                        <div class="form-group">
                            <label for="category_id">Родительская категория</label>
                            <?php if(!empty($_SESSION['val']['category_id'])): ?>
                                <div class="text-danger"><?php print_r(array_shift($_SESSION['val']['category_id'])); unset($_SESSION['val']['category_id'])?></div>
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
                            ]);?>
                        </div>

                        <div class="form-group">
                            <label for="brand_id">ID бренда</label>
                            <input type="text" name="brand_id" class="form-control" id="brand_id"
                                   placeholder="ID бренда" value="<?= h($product['brand_id']) ?>">
                        </div>

                        <div class="form-group">
                            <label for="keywords">Ключевые слова</label>
                            <input type="text" name="keywords" class="form-control" id="keywords"
                                   placeholder="Ключевые слова" value="<?= h($product['keywords']) ?>">
                        </div>

                        <div class="form-group">
                            <label for="description">Описание товара</label>
                            <input type="text" name="description" class="form-control" id="description"
                                   placeholder="Описание товара" value="<?= h($product['description']) ?>">
                        </div>

                        <div class="form-group">
                            <label for="price">Цена</label>
                            <?php if(!empty($_SESSION['val']['price'])): ?>
                                <div class="text-danger"><?php print_r(array_shift($_SESSION['val']['price'])); unset($_SESSION['val']['price'])?></div>
                            <?php endif; ?>
                            <input type="text" name="price" class="form-control" id="price"
                                   placeholder="Цена" value="<?= h($product['price']) ?>">
                        </div>

                        <div class="form-group">
                            <label for="old_price">Старая цена</label>
                            <?php if(!empty($_SESSION['val']['old_price'])): ?>
                                <div class="text-danger"><?php print_r(array_shift($_SESSION['val']['old_price'])); unset($_SESSION['val']['old_price'])?></div>
                            <?php endif; ?>
                            <input type="text" name="old_price" class="form-control" id="old_price"
                                   placeholder="Старая цена" value="<?= h($product['old_price']) ?>">
                        </div>

                        <div class="form-group">
                            <label for="content">Контент</label>
                            <textarea name="content" id="editor1" cols="180" rows="10"
                                      value="<?= h($product['content']) ?>">
                                </textarea>
                        </div>

                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="status" <?= $product['status'] ? ' checked' : null;?>> Статус
                            </label>
                        </div>

                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="hit" <?=$product['hit'] ? ' checked' : null;?>> Хит
                            </label>
                        </div>

                        <div class="form-group">
                            <label for="related">Связанные товары</label>
                            <select name="related[]"  class="form-control select2 select2-blue" id="related" multiple>
                                <?php if (!empty($related_product)): ?>
                                    <?php foreach ($related_product as $item): ?>
                                        <option value="<?=$item['related_id'];?>" selected><?=$item['title'];?></option>
                                    <?php endforeach;?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <?php new  \App\Widgets\Filter\Filter($filter, WWW . '/filter/admin_filter_tpl.php');?>

                        <div class="form-group container">
                            <div class="col-md-4">
                                <div class="box box-danger box-solid file-upload">
                                    <div class="box-header">
                                        <h3 class="box-title">Базовое изображение</h3>
                                    </div>
                                    <div class="box-body">
                                        <div id="single" class="btn btn-success"
                                             data-url="/product/add-image" data-name="single">Выбрать файл</div>
                                        <p><small>рекомендуемые размеры: 125x200</small></p>
                                        <div class="single">
                                            <img src="/images/<?= $product['img'] ?>" alt="" style="max-height: 150px;">
                                        </div>
                                    </div>

                                    <div class="overlay">
                                        <i class="fa fa-refresh fa-spin"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="box box-primary box-solid file-upload">
                                    <div class="box-header">
                                        <h3 class="box-title">Картинки галереи</h3>
                                    </div>
                                    <div class="box-body">
                                        <div id="multi" class="btn btn-success"
                                             data-url="/product/add-image" data-name="multi">Выбрать файл</div>
                                        <p><small>рекомендуемые размеры:700x1000</small></p>
                                        <div class="multi">
                                            <?php if(!empty($gallery)): ?>
                                                <?php foreach ($gallery as $item): ?>
                                                    <img src="/images/<?=$item['img'];?>" alt="" style="max-height: 150px; cursor: pointer;"
                                                         data-id="<?=$product['id'];?>" data-src="<?=$item['img'];?>" class="del-item">
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="overlay">
                                        <i class="fa fa-refresh fa-spin"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="box-footer">
                            <input type="hidden" name="id" value="<?= $product['id']; ?>">
                            <button type="submit" class="btn btn-success">Сохранить</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->


