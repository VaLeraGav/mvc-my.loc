<div class="login-box-body">

    <?php if(!empty($message)): ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            <h4><i class="icon fa fa-ban"></i>Ошибка!</h4>
            <?= $message; ?>
        </div>
    <?php endif; ?>

    <form action="<?= ADMIN ?>/user/login-admin" method="post">
        <div class="form-group has-feedback">
            <input name="email" type="text" class="form-control" placeholder="Email" value="<?= $login ?>"/>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input name="password" type="password" class="form-control" placeholder="Password">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
            <!-- /.col -->
            <div class="col-sm-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
            </div>
            <!-- /.col -->
        </div>
    </form>
</div>
