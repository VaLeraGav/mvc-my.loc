<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Новая группа фильтров
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= ADMIN ?>"><i class="fa fa-dashboard"></i>Главная</a></li>
        <li class="breadcrumb-item"><a href="<?= ADMIN ?>/filter/attribute">Фильтр</a></li>
        <li class="breadcrumb-item active">Новая группа фильтров</li>
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
                    <form action="<?= ADMIN; ?>/filter/attribute-add" method="post" novalidate>

                        <div class="form-group">
                            <label for="title">Наименование группы фильтров</label>
                            <?php if(!empty($_SESSION['val']['value'])): ?>
                                <div class="text-danger"><?php print_r(array_shift($_SESSION['val']['value'])); unset($_SESSION['val']['value'])?></div>
                            <?php endif; ?>
                            <input type="text" name="value" class="form-control" id="title"
                                   placeholder="Наименование категории" value="<?= $category['title'] ?? '' ?>">
                        </div>

                        <div class="form-group">
                            <label for="category_id">Группа</label>
                            <?php if(!empty($_SESSION['val']['attr_group_id'])): ?>
                                <div class="text-danger"><?php print_r(array_shift($_SESSION['val']['attr_group_id'])); unset($_SESSION['val']['attr_group_id'])?></div>
                            <?php endif; ?>
                            <select name="attr_group_id" id="category_id" class="form-control">
                                <option value="">Выберите группу</option>
                                <?php foreach ($group as $item): ?>
                                    <option value="<?=$item['id'];?>"><?=$item['title'];?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

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
