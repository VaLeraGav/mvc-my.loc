<!--start-breadcrumbs-->
<div class="breadcrumbs">
    <div class="container">
        <div class="breadcrumbs-main">
            <ol class="breadcrumb">
                <li><a href="<?= PATH ?>">Home</a></li>
                <li class="active">Login</li>
            </ol>
        </div>
    </div>
</div>
<!--end-breadcrumbs-->

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

<!--prdt-starts-->
<div class="prdt">
    <div class="container">
        <div class="prdt-top">
            <div class="col-md-12">
                <div class="product-one login">
                    <div class="register-top heading">
                        <h2>LOGIN</h2>
                    </div>

                    <div class="register-main">
                        <div class="col-md-6 account-left">
                            <form method="post" action="user/login" role="form" data-toggle="validator">
                                <div class="form-group has-feedback">

                                    <input type="text" name=email class="form-control" id="login" placeholder="Email" value="<?=
                                    $email ?>">
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                </div>
                                <?php if(!empty($error)): ?>
                                    <div class="text-danger"><?php print_r($error); ?></div>
                                <?php endif; ?>
                                <div class="form-group has-feedback">
                                    <input type="password" name="password" class="form-control" id="password" placeholder="Password" autocomplete="off">
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                </div>
                                <button type="submit" class="btn btn-default">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>