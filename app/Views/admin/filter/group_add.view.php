<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Новый фильтр
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= ADMIN ?>"><i class="fa fa-dashboard"></i>Главная</a></li>
        <li class="breadcrumb-item"><a href="<?= ADMIN ?>/filter/attribute">Фильтр</a></li>
        <li class="breadcrumb-item active">Новый фильтр</li>
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
                    <form action="<?= ADMIN; ?>/filter/group-add" method="post" novalidate>

                        <div class="form-group">
                            <label for="title">Наименование группы фильтров</label>
                            <?php if(!empty($errors['title'])): ?>
                                <div class="text-danger"><?php print_r(array_shift($errors['title'])) ?></div>
                            <?php endif; ?>
                            <input type="text" name="title" class="form-control" id="title">
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
