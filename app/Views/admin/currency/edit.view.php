<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Редактирование валюты
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= ADMIN ?>"><i class="fa fa-dashboard"></i>Главная</a></li>
        <li class="breadcrumb-item"><a href="<?= ADMIN ?>/currency">Список валют</a></li>
        <li class="breadcrumb-item active">Редактирование валюты</li>
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
                    <form action="<?= ADMIN; ?>/currency/edit" method="post" novalidate>

                        <div class="form-group">
                            <label for="title">Наименование валюты</label>
                            <?php if(!empty($_SESSION['val']['title'])): ?>
                                <div class="text-danger"><?php print_r(array_shift($_SESSION['val']['title'])); unset($_SESSION['val']['title'])?></div>
                            <?php endif; ?>
                            <input type="text" name="title" class="form-control" value="<?= $currency['title'] ?>">
                        </div>

                        <div class="form-group">
                            <label for="title">Код валюты</label>
                            <?php if(!empty($_SESSION['val']['code'])): ?>
                                <div class="text-danger"><?php print_r(array_shift($_SESSION['val']['code'])); unset($_SESSION['val']['code'])?></div>
                            <?php endif; ?>
                            <input type="text" name="code" class="form-control" value="<?= $currency['code']?>">
                        </div>

                        <div class="form-group">
                            <label for="title">Символ слева</label>
                            <?php if(!empty($_SESSION['val']['symbol_left'])): ?>
                                <div class="text-danger"><?php print_r(array_shift($_SESSION['val']['symbol_left'])); unset($_SESSION['val']['symbol_left'])?></div>
                            <?php endif; ?>
                            <input type="text" name="symbol_left" class="form-control" value="<?= $currency['symbol_left']?>">
                        </div>

                        <div class="form-group">
                            <label for="title">Символ справа</label>
                            <?php if(!empty($_SESSION['val']['symbol_right'])): ?>
                                <div class="text-danger"><?php print_r(array_shift($_SESSION['val']['symbol_right'])); unset($_SESSION['val']['symbol_right'])?></div>
                            <?php endif; ?>
                            <input type="text" name="symbol_right" class="form-control" value="<?= $currency['symbol_right']?>">
                        </div>

                        <div class="form-group">
                            <label for="title">Значение</label>
                            <?php if(!empty($_SESSION['val']['value'])): ?>
                                <div class="text-danger"><?php print_r(array_shift($_SESSION['val']['value'])); unset($_SESSION['val']['value'])?></div>
                            <?php endif; ?>
                            <input type="text" name="value" class="form-control" value="<?= $currency['value']?>">
                        </div>

                        <div class="form-group">
                            <label for="base">
                                <input type="checkbox" name="base" <?php if($currency['base']) echo ' checked' ?>>
                                Базовая валюта
                            </label>
                        </div>

                        <div class="box-footer">
                            <input type="hidden" name="id" value="<?= $currency['id'] ?>">
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
