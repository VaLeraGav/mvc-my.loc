<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Фильтры
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= ADMIN ?>"><i class="fa fa-dashboard"></i>Главная</a></li>
        <li class="breadcrumb-item active">Фильтры</li>
    </ol>
</section>
<!-- /.content-header -->

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
                    <div class="table-responsive">

                        <a href="<?=ADMIN;?>/filter/attribute-add" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i>Добавить фильтр</a>

                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Наименование</th>
                                <th>Группа</th>
                                <th>Действие</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($attrs as $attr): ?>
                                <tr>
                                    <td><?=$attr['value'];?></td>
                                    <td><?=$attr['title'];?></td>
                                    <td>
                                        <a href="<?=ADMIN;?>/filter/attribute-edit?id=<?=$attr['id'];?>"><i class="fa fa-fw fa-pencil"></i></a>
                                        <a href="<?=ADMIN;?>/filter/attribute-delete?id=<?=$attr['id'];?>"><i class="fa fa-fw fa-close text-danger delete"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->

</section>
<!-- /.content -->

