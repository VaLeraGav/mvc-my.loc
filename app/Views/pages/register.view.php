<section class="vh-100 bg-image"
         style="background-color: #CCCCCC;">
    <div class="mask d-flex align-items-center h-100 gradient-custom-3">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                    <div class="card" style="border-radius: 15px;">
                        <div class="card-body p-4">
                            <h2 class="text-center mb-1">Create an account</h2>
                            <?php //dpre($errors ?? ''); ?>
                            <form action="/registration" method="post">
                                <div class="form-outline mb-2">
                                    <label class="form-label">Your Name</label>
                                    <input type="text" name="name" class="form-control form-control-lg"
                                           value="<?= $users['name'] ?? '' ?>"/>
                                </div>

                                <?php if(!empty($errors['name'])): ?>
                                <p class="text-danger"><?php print_r(array_shift($errors['name'])); ?></p>
                                <?php endif; ?>

                                <div class="form-outline mb-4">
                                    <label class="form-label">Your Email</label>
                                    <input type="text" name="email" class="form-control form-control-lg"
                                           value="<?= $users['email'] ?? "" ?>"/>
                                </div>
                                <?php if(!empty($errors['email'])): ?>
                                    <p class="text-danger"><?php print_r(array_shift($errors['email'])); ?></p>
                                <?php endif; ?>

                                <div class="form-outline mb-4">
                                    <label class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control form-control-lg"
                                           placeholder="********"/>
                                </div>
                                <?php if(!empty($errors['password'])): ?>
                                    <p class="text-danger"><?php print_r(array_shift($errors['password'])); ?></p>
                                <?php endif; ?>


                                <div class="form-outline mb-4">
                                    <label class="form-label">Repeat your password</label>
                                    <input type="password" name="password_confirmation"
                                           class="form-control form-control-lg" placeholder="********"/>
                                </div>
                                <?php if(!empty($errors['password_confirmation'])): ?>
                                    <p class="text-danger"><?php print_r(array_shift($errors['password_confirmation'])); ?></p>
                                <?php endif; ?>

                                <div class="d-flex justify-content-center text-light">
                                    <button type="submit" class="btn btn-dark btn-block btn-lg ">Register</button>
                                </div>
                                <p class="text-center text-muted mb-0">Have already an account?
                                    <a href="#!" class="fw-bold text-body">
                                        <u>Login here</u>
                                    </a>
                                </p>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>