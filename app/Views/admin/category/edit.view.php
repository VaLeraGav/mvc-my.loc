<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Редактирование категории: <?= $category['title'] ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= ADMIN ?>"><i class="fa fa-dashboard"></i>Главная</a></li>
        <li class="breadcrumb-item"><a href="<?= ADMIN ?>/category">Редактирование категорий</a></li>
        <li class="breadcrumb-item active">Новая категория</li>
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
                    <form action="<?= ADMIN; ?>/category/edit" method="post" novalidate>

                        <div class="form-group">
                            <label for="title">Наименование категории</label>
                            <input type="text" name="title" class="form-control" id="title"
                                   placeholder="Наименование категории" value="<?= $category['title'] ?? '' ?>" required>
                        </div>
                        <?php if(!empty($_SESSION['val']['title'])): ?>
                            <div class="text-danger"><?php print_r(array_shift($_SESSION['val']['title'])); unset($_SESSION['val']['title'])?></div>
                        <?php endif; ?>

                        <div class="form-group">
                            <label for="title">Alias</label>
                            <input type="text" name="alias" class="form-control" id="title"
                                   placeholder="alias для поиска" value="<?= $category['alias'] ?? '' ?>" required>
                        </div>
                        <?php if(!empty($_SESSION['val']['alias'])): ?>
                            <div class="text-danger"><?php print_r($_SESSION['val']['alias']);  unset($_SESSION['val']['alias'])?></div>
                        <?php endif; ?>

                        <div class="form-group">
                            <label for="parent_id">Родительская категория</label>
                            <?php new \App\Widgets\Menu\Menu([
                                'tpl' => WWW . '/menu/select.php',
                                'container' => 'select',
                                'cache' => 0,
                                'cackeKey' => 'admin_select',
                                'attrs' => [
                                    'name' => 'parent_id',
                                    'id' => 'parent_id'
                                ],
                                'class' => 'form-control',
                                'prepend' => '<option value="0">Самостоятельная категория</option>',
                            ]);?>
                        </div>
                        <?php if(!empty($_SESSION['val']['parent_id'])): ?>
                            <div class="text-danger"><?php print_r(array_shift($_SESSION['val']['parent_id'])); unset($_SESSION['val']['parent_id']) ?></div>
                        <?php endif; ?>


                        <div class="form-group">
                            <label for="keywords">Ключевые слова</label>
                            <input type="text" name="keywords" class="form-control" id="keywords"
                                   placeholder="Ключевые слова" value="<?= $category['keywords'] ?? '' ?>">
                        </div>

                        <div class="form-group">
                            <label for="description">Описание категории</label>
                            <input type="text" name="description" class="form-control" id="description"
                                   placeholder="Описание категории" value="<?= $category['description'] ?? '' ?>">
                        </div>

                        <div class="box-footer">
                            <input type="hidden" name="id" value="<?= $category['id']; ?>">
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