<!--start-breadcrumbs-->
<div class="breadcrumbs">
    <div class="container">
        <div class="breadcrumbs-main">
            <ol class="breadcrumb">
                <li><a href="<?= PATH ?>">Home</a></li>
                <li class="active">Cart</li>
            </ol>
        </div>
    </div>
</div>
<!--end-breadcrumbs-->

<?php //dpre($_SESSION) ?>

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
                <div class="product-one cart">
                    <div class="register-top heading">
                        <h2>Checkout</h2>
                    </div>
                    <br><br>
                    <?php if(!empty($_SESSION['cart'])):?>
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                <tr>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach($_SESSION['cart'] as $id => $item): ?>
                                    <tr>
                                        <td><a href="product/<?=$item['alias'] ?>"><img src="images/<?= $item['img'] ?>" alt="<?=$item['title'] ?>"></a></td>
                                        <td><a href="product/<?=$item['alias'] ?>"><?=$item['title'] ?></a></td>
                                        <td><?=$item['qty'] ?></td>
                                        <td><?=$item['price'] ?></td>
                                        <td><a href="/cart/delete?id=<?=$id ?>"><span data-id="<?=$id ?>" class="glyphicon glyphicon-remove text-danger del-item" aria-hidden="true"></span></a></td>
                                    </tr>
                                <?php endforeach;?>
                                <tr>
                                    <td>Total:</td>
                                    <td colspan="4" class="text-right cart-qty"><?=$_SESSION['cart.qty'] ?></td>
                                </tr>
                                <tr>
                                    <td>In the amount of:</td>
                                    <td colspan="4" class="text-right cart-sum"><?= $_SESSION['cart.currency']['symbol_left'] . $_SESSION['cart.sum'] . " {$_SESSION['cart.currency']['symbol_right']}" ?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div>
                            <form method="post" action="cart/checkout" role="form" data-toggle="validator">
                                <?php if(!\App\Models\UserModel::isAuth()): ?>

                                    <div class="col-md-6 account-left">

                                        <div class="form-group has-feedback">
                                            <?php if(!empty($errors['login'])): ?>
                                                <div class="text-danger"><?php print_r(array_shift($errors['login'])) ?></div>
                                            <?php endif; ?>
                                            <input type="text" name="login" class="form-control" id="login" placeholder="Login" data-error="Login must be at least 4 characters"
                                                   value="<?= $users['login'] ?? '' ?>" >
                                        </div>

                                        <div class="form-group has-feedback">
                                            <?php if(!empty($errors['name'])): ?>
                                                <div class="text-danger"><?php print_r(array_shift($errors['name'])) ?></div>
                                            <?php endif; ?>
                                            <input type="text" name="name" class="form-control" id="name" placeholder="Name" value="<?= $users['name'] ?? '' ?>" >
                                        </div>

                                        <div class="form-group has-feedback">
                                            <?php if(!empty($errors['email'])): ?>
                                                <div class="text-danger"><?php print_r(array_shift($errors['email'])) ?></div>
                                            <?php endif; ?>
                                            <input type="text" name="email" class="form-control" id="email" placeholder="Email" value="<?=  $users['email'] ?? '' ?>" >
                                        </div>

                                        <div class="form-group has-feedback">
                                            <?php if(!empty($errors['address'])): ?>
                                                <div class="text-danger"><?php print_r(array_shift($errors['address'])) ?></div>
                                            <?php endif; ?>
                                            <input type="text" name="address" class="form-control" id="address" placeholder="Address" value="<?= $users['address'] ?? '' ?>" >
                                        </div>
                                    </div>

                                    <div class="col-md-6 account-left">

                                        <div class="form-group has-feedback">
                                            <?php if(!empty($errors['password'])): ?>
                                                <div class="text-danger"><?php print_r(array_shift($errors['password'])) ?></div>
                                            <?php endif; ?>
                                            <input type="password" name="password" class="form-control" id="password" placeholder="Password" data-minlength="6" data-error="Password must be at least 6 characters">
                                        </div>

                                        <div class="form-group has-feedback">
                                            <input type="password" name="password_confirmation" class="form-control" id="password_retype" placeholder="Retype password" data-match="#password" data-match-error="Whoops, these don't match"
                                                   data-required-error="Fill in this field">
                                        </div>

                                    </div>
                                <?php endif; ?>
                                <div class="col-md-6 account-left">
                                    <div class="form-group">
                                        <label for="address">Note</label>
                                        <textarea name="note" class="form-control"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-default">Checkout</button>
                                </div>
                            </form>
                        </div>
                    <?php else: ?>
                        <h3>Cart is empty</h3>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>
</div>
<!--product-end-->