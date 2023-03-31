<!-- хлебные крошки -->
<div class="breadcrumbs">
    <div class="container">
        <div class="breadcrumbs-main">
            <ol class="breadcrumb">
                <li><a href="<?= PATH ?>">Home</a></li>
                <li class="active">Register</li>
            </ol>
        </div>
    </div>
</div>

<?php if(isset($_SESSION['success'])): ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-success">
                    <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="register">
    <div class="container">
        <div class="register-top heading">
            <h2>REGISTER</h2>
        </div>
        <div class="register-main">
            <form action="user/signup" method="post">
                <div class="col-md-6 account-left">

                    <?php if(!empty($errors['login'])): ?>
                        <div class="text-danger"><?php print_r(array_shift($errors['login'])) ?></div>
                    <?php endif; ?>
                    <input name="login" placeholder="Login" type="text" value="<?= $users['login'] ?? '' ?>">

                    <?php if(!empty($errors['name'])): ?>
                        <div class="text-danger"><?php print_r(array_shift($errors['name'])) ?></div>
                    <?php endif; ?>
                    <input name="name" placeholder="Name" type="text" value="<?= $users['name'] ?? '' ?>">

                    <?php if(!empty($errors['email'])): ?>
                        <div class="text-danger"><?php print_r(array_shift($errors['email'])) ?></div>
                    <?php endif; ?>
                    <input name="email" placeholder="Email address" type="text" value="<?= $users['email'] ?? '' ?>">

                    <?php if(!empty($errors['address'])): ?>
                        <div class="text-danger"><?php print_r(array_shift($errors['address'])) ?></div>
                    <?php endif; ?>
                    <input name="address" placeholder="Address" type="text" value="<?= $users['address'] ?? '' ?>">

                    <button type="submit" class="btn btn-default">Submit</button>
                </div>
                <div class="col-md-6 account-left">
                    <?php if(!empty($errors['password'])): ?>
                        <div class="text-danger"><?php print_r(array_shift($errors['password'])) ?></div>
                    <?php endif; ?>
                    <input name="password" placeholder="Password" type="password" autocomplete="off">

                    <?php if(!empty($errors['password_confirmation'])): ?>
                        <div class="text-danger"><?php print_r(array_shift($errors['password_confirmation'])) ?></div>
                    <?php endif; ?>
                    <input name="password_confirmation" placeholder="Retype password" type="password" autocomplete="off">
                </div>
                <div class="clearfix"></div>
            </form>
        </div>
    </div>
</div>