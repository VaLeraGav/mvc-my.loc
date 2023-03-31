<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Редактирование пользователя
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= ADMIN ?>"><i class="fa fa-dashboard"></i>Главная</a></li>
        <li><a href="<?= ADMIN ?>/user">Список пользователей</a></li>
        <li class="breadcrumb-item active">Редактирование пользователя</li>
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

<?php //dpre($_SESSION) ?>

<!-- Main content -->
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <form action="<?= ADMIN; ?>/user/edit" method="post">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="login">Логин</label>
                            <?php if(!empty($_SESSION['val']['login'])): ?>
                                <div class="text-danger"><?php print_r(array_shift($_SESSION['val']['login'])); unset($_SESSION['val']['login'])?></div>
                            <?php endif; ?>
                            <input type="text" name="login" class="form-control" id="login" value="<?=h($user['login']);?>">
                        </div>

                        <div class="form-group">
                            <label for="password">Пароль</label>
                            <?php if(!empty($_SESSION['val']['password'])): ?>
                                <div class="text-danger"><?php print_r(array_shift($_SESSION['val']['password'])); unset($_SESSION['val']['password'])?></div>
                            <?php endif; ?>
                            <input type="text" name="password" class="form-control" id="password" placeholder="Введите пароль, если хотите его изменить">
                        </div>

                        <div class="form-group">
                            <label for="name">Имя</label>
                            <?php if(!empty($_SESSION['val']['name'])): ?>
                                <div class="text-danger"><?php print_r(array_shift($_SESSION['val']['name'])); unset($_SESSION['val']['name'])?></div>
                            <?php endif; ?>
                            <input type="text" name="name" class="form-control" id="name" value="<?=h($user['name']);?>">
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <?php if(!empty($_SESSION['val']['email'])): ?>
                                <div class="text-danger"><?php print_r(array_shift($_SESSION['val']['email'])); unset($_SESSION['val']['email'])?></div>
                            <?php endif; ?>
                            <input type="email" name="email" class="form-control" id="email" value="<?=h($user['email']);?>">
                        </div>

                        <div class="form-group">
                            <label for="address">Адрес</label>
                            <?php if(!empty($_SESSION['val']['address'])): ?>
                                <div class="text-danger"><?php print_r(array_shift($_SESSION['val']['address'])); unset($_SESSION['val']['address'])?></div>
                            <?php endif; ?>
                            <input type="text" name="address" class="form-control" id="address" value="<?=h($user['address']);?>">
                        </div>

                        <div class="form-group">
                            <label>Роль</label>
                            <select name="role" id="role" class="form-control">
                                <option value="user" <?php if($user['role'] == 'user') echo ' selected';?>>Пользователь</option>
                                <option value="admin" <?php if($user['role'] == 'admin') echo ' selected';?>>Администратор</option>
                            </select>
                        </div>

                        <div class="card-footer">
                            <input type="hidden" name="id" value="<?= $user['id'];?>">
                            <button type="submit" class="btn btn-primary">Изменить</button>
                        </div>
                    </div>
                </form>
            </div>

            <h3>Заказы пользователя</h3>
            <div class="box">
                <div class="box-body">
                    <?php if($orders): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Покупатель</th>
                                    <th>Статус</th>
                                    <th>Сумма</th>
                                    <th>Дата создания</th>
                                    <th>Дата изменения</th>
                                    <th>Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach($orders as $order): ?>
                                    <?php $class = $order['status'] ? 'success' : ''; ?>
                                    <tr class="<?=$class;?>">
                                        <td><?=$order['id']?></td>
                                        <td><?=$order['status'] ? 'Завершен' : 'Новый' ;?></td>
                                        <td><?=$order['sum']?><?=$order['currency']?></td>
                                        <td><?=$order['date']?></td>
                                        <td><?=$order['update_at']?></td>
                                        <td>
                                            <a href="<?=ADMIN;?>/order/view?id=<?=$order['id'];?>"><i class="fa fa-fw fa-eye"></i></a>
                                            <a href="<?=ADMIN;?>/order/delete?id=<?=$order['id'];?>"><i class="delete fa fa-fw fa-close text-danger"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-danger">Пользователь пока ничего не заказывал...</p>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
    <!-- /.row -->

</section>