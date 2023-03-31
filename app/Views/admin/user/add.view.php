<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
       Новый пользователь
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= ADMIN ?>"><i class="fa fa-dashboard"></i>Главная</a></li>
        <li><a href="<?= ADMIN ?>/user">Список пользователей</a></li>
        <li class="breadcrumb-item active">Новый пользователь</li>
    </ol>
</section>

<div class="row">
    <div class="col-md-12">
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
                <form action="<?= ADMIN; ?>/user/add" method="post">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="login">Логин</label>
                            <?php if(!empty($errors['login'])): ?>
                                <div class="text-danger"><?php print_r(array_shift($errors['login'])) ?></div>
                            <?php endif; ?>
                            <input type="text" name="login" class="form-control" id="login"  value="<?= $users['login'] ?? '' ?>">
                        </div>

                        <div class="form-group">
                            <label for="password">Пароль</label>
                            <?php if(!empty($errors['password'])): ?>
                                <div class="text-danger"><?php print_r(array_shift($errors['password'])) ?></div>
                            <?php endif; ?>
                            <input type="text" name="password" class="form-control" id="password"  value="<?= $users['password'] ?? '' ?>">
                        </div>

                        <div class="form-group">
                            <label for="name">Имя</label>
                            <?php if(!empty($errors['name'])): ?>
                                <div class="text-danger"><?php print_r(array_shift($errors['name'])) ?></div>
                            <?php endif; ?>
                            <input type="text" name="name" class="form-control" id="name" value="<?= $users['name'] ?? '' ?>">
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <?php if(!empty($errors['email'])): ?>
                                <div class="text-danger"><?php print_r(array_shift($errors['email'])) ?></div>
                            <?php endif; ?>
                            <input type="email" name="email" class="form-control" id="email" value="<?= $users['email'] ?? '' ?>">
                        </div>

                        <div class="form-group">
                            <label for="address">Адрес</label>
                            <?php if(!empty($errors['address'])): ?>
                                <div class="text-danger"><?php print_r(array_shift($errors['address'])) ?></div>
                            <?php endif; ?>
                            <input type="text" name="address" class="form-control" id="address"  value="<?= $users['address'] ?? '' ?>">
                        </div>

                        <div class="form-group">
                            <label>Роль</label>
                            <select name="role" id="role" class="form-control">
                                <option value="user">Пользователь</option>
                                <option value="admin">Администратор</option>
                            </select>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Добавить</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.row -->

</section>