<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Панель управления
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= ADMIN ?>"><i class="fa fa-dashboard"></i>Главная</a></li>
        <li class="breadcrumb-item active">Очистка кеша</li>
    </ol>
</section>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Название</th>
                                <th>Описание</th>
                                <th>Действие</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Кеш категорий</td>
                                <td>Меню категорий на сайте. Кешируется на 1 час</td>
                                <td>
                                    <a href="<?=ADMIN;?>/cache/delete?key=category"><i class="fa fa-fw fa-close text-danger delete"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>Кеш фильтров</td>
                                <td>Кеш фильтров и групп фильтров . Кешируется на 1 час</td>
                                <td>
                                    <a href="<?=ADMIN;?>/cache/delete?key=filter"><i class="fa fa-fw fa-close text-danger delete"></i></a>
                                </td>
                            </tr>
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

